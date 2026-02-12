<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\PaymentProof;
use App\Mail\UserApproved;
use Illuminate\Support\Facades\Mail;

class Approve extends Component
{
    use WithPagination;

    public $selectedUser = null;
    public $selectedProof = null;
    public $showUserDetail = false;
    public $adminNote = '';
    public $filterStatus = 'pending';

    protected $queryString = ['filterStatus'];

    public function updated($property)
    {
        if ($property === 'filterStatus') {
            $this->resetPage();
        }
    }

    public function viewUser($userId)
    {
        $this->selectedUser = User::with(['paymentProofs' => function($q) {
            $q->latest();
        }])->find($userId);

        $this->selectedProof = $this->selectedUser->paymentProofs->first();
        $this->showUserDetail = true;
        $this->adminNote = '';
    }

    public function closeUserDetail()
    {
        $this->showUserDetail = false;
        $this->selectedUser = null;
        $this->selectedProof = null;
        $this->adminNote = '';
    }

    public function approveUser()
    {
        if (!$this->selectedUser) {
            return;
        }

        // Approve user
        $this->selectedUser->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        // Approve payment proof if exists
        if ($this->selectedProof) {
            $this->selectedProof->update([
                'status' => 'approved',
                'admin_note' => $this->adminNote,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
        }

        $approver = auth()->user();
        Mail::to($this->selectedUser->email)->send(new UserApproved(
            $this->selectedUser->fresh('approver'),
            $this->selectedProof?->fresh('approver'),
            $approver
        ));

        $this->dispatch('notify', message: 'User approved successfully!', type: 'success');
        $this->closeUserDetail();
    }

    public function rejectUser()
    {
        if (!$this->selectedUser) {
            return;
        }

        // Reject payment proof if exists
        if ($this->selectedProof) {
            $this->selectedProof->update([
                'status' => 'rejected',
                'admin_note' => $this->adminNote,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
        }

        // Keep user unapproved
        $this->dispatch('notify', message: 'User rejected.', type: 'info');
        $this->closeUserDetail();
    }

    public function rejectAndDelete()
    {
        if (!$this->selectedUser) {
            return;
        }

        $userName = $this->selectedUser->name;

        // Delete payment proofs first
        if ($this->selectedProof) {
            // Delete payment slip file if exists
            if ($this->selectedProof->proof_file) {
                \Storage::disk('public')->delete($this->selectedProof->proof_file);
            }
            $this->selectedProof->delete();
        }

        // Delete profile image if exists
        if ($this->selectedUser->profile_image) {
            \Storage::disk('public')->delete($this->selectedUser->profile_image);
        }

        // Delete user
        $this->selectedUser->delete();

        $this->dispatch('notify', message: "ลบบัญชี {$userName} เรียบร้อยแล้ว", type: 'success');
        $this->closeUserDetail();
    }

    public function rejectAndRequestRevision()
    {
        if (!$this->selectedUser) {
            return;
        }

        // Update payment proof status to rejected with note
        if ($this->selectedProof) {
            $this->selectedProof->update([
                'status' => 'rejected',
                'admin_note' => $this->adminNote ?: 'กรุณาตรวจสอบและแก้ไขข้อมูลให้ถูกต้อง',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
        }

        // Keep user unapproved for revision
        $this->selectedUser->update([
            'is_approved' => false,
            'approved_at' => null,
        ]);

        // TODO: Send email notification to user
        // Mail::to($this->selectedUser->email)->send(new RevisionRequestMail($this->selectedUser, $this->adminNote));

        $this->dispatch('notify', message: 'ส่งคำขอแก้ไขไปยังผู้ใช้แล้ว', type: 'warning');
        $this->closeUserDetail();
    }

    public function render()
    {
        // Initialize empty collections
        $pendingUsers = collect();
        $approvedUsers = collect();
        $rejectedUsers = collect();
        $users = collect();

        // Get users based on filter status
        if ($this->filterStatus === 'pending') {
            // Show pending approvals
            $pendingUsers = User::with(['paymentProofs' => function($q) {
                $q->latest()->limit(1);
            }])
            ->where('is_approved', false)
            ->latest()
            ->paginate(10, ['*'], 'page');
        } elseif ($this->filterStatus === 'approved') {
            // Show approved users
            $approvedUsers = User::with(['paymentProofs' => function($q) {
                $q->where('status', 'approved')->latest()->limit(1);
            }])
            ->where('is_approved', true)
            ->latest()
            ->paginate(10, ['*'], 'page');
        } elseif ($this->filterStatus === 'rejected') {
            // Show rejected users (with rejected payment proofs)
            $rejectedUsers = User::with(['paymentProofs' => function($q) {
                $q->where('status', 'rejected')->latest()->limit(1);
            }])
            ->whereHas('paymentProofs', function($q) {
                $q->where('status', 'rejected');
            })
            ->latest()
            ->paginate(10, ['*'], 'page');
        } else { // 'all'
            // Show all users
            $users = User::with(['paymentProofs' => function($q) {
                $q->latest()->limit(1);
            }])
            ->latest()
            ->paginate(10, ['*'], 'page');
        }

        return view('livewire.dashboard.approve', [
            'pendingUsers' => $pendingUsers,
            'approvedUsers' => $approvedUsers,
            'rejectedUsers' => $rejectedUsers,
            'users' => $users,
        ]);
    }
}
