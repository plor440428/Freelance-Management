<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\ApprovalLog;
use App\Models\PaymentProof;
use App\Mail\UserApproved;
use App\Mail\UserRevisionRequested;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

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

        // Select pending proof first, then fall back to latest
        $this->selectedProof = $this->selectedUser->paymentProofs
            ->firstWhere('status', 'pending') 
            ?? $this->selectedUser->paymentProofs->first();
        
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

        try {
            // Approve user
            $this->selectedUser->update([
                'is_approved' => true,
                'approved_at' => now(),
                'approved_by' => auth()->id(),
                'rejection_reason' => null,
                'rejected_at' => null,
                'rejected_by' => null,
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

            ApprovalLog::create([
                'user_id' => $this->selectedUser->id,
                'action' => 'approved',
                'reason' => $this->adminNote,
                'acted_by' => auth()->id(),
                'meta' => [
                    'payment_proof_id' => $this->selectedProof?->id,
                ],
            ]);

            $approver = auth()->user();

            try {
                Mail::to($this->selectedUser->email)->send(new UserApproved(
                    $this->selectedUser->fresh('approver'),
                    $this->selectedProof?->fresh('approver'),
                    $approver
                ));
            } catch (\Throwable $e) {
                \Log::error('Approval email failed', [
                    'user_id' => $this->selectedUser->id,
                    'error' => $e->getMessage(),
                ]);

                $this->dispatch('notify', message: 'อนุมัติแล้ว แต่ส่งอีเมลไม่สำเร็จ: ' . $e->getMessage(), type: 'warning');
            }

            $this->dispatch('notify', message: 'อนุมัติสำเร็จแล้ว', type: 'success');
            $this->closeUserDetail();
        } catch (\Throwable $e) {
            \Log::error('Approve user failed', [
                'user_id' => $this->selectedUser->id,
                'error' => $e->getMessage(),
            ]);

            $this->dispatch('notify', message: 'อนุมัติไม่สำเร็จ: ' . $e->getMessage(), type: 'error');
        }
    }

    public function rejectUser()
    {
        if (!$this->selectedUser) {
            return;
        }

        $validated = $this->validate([
            'adminNote' => 'required|string|min:5|max:2000',
        ], [
            'adminNote.required' => 'กรุณาระบุเหตุผลที่ไม่อนุมัติ',
            'adminNote.min' => 'เหตุผลต้องมีอย่างน้อย 5 ตัวอักษร',
        ]);

        $reason = trim($validated['adminNote']);

        $revisionUrl = URL::temporarySignedRoute(
            'registration.revision',
            now()->addDays(7),
            ['user' => $this->selectedUser->id]
        );

        // Reject payment proof if exists
        if ($this->selectedProof) {
            $this->selectedProof->update([
                'status' => 'rejected',
                'admin_note' => $reason,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
        }

        // Keep user unapproved for revision
        $this->selectedUser->update([
            'is_approved' => false,
            'approved_at' => null,
            'approved_by' => null,
            'rejection_reason' => $reason,
            'rejected_at' => now(),
            'rejected_by' => auth()->id(),
        ]);

        ApprovalLog::create([
            'user_id' => $this->selectedUser->id,
            'action' => 'rejected_revision_requested',
            'reason' => $reason,
            'acted_by' => auth()->id(),
            'meta' => [
                'payment_proof_id' => $this->selectedProof?->id,
            ],
        ]);

        try {
            Mail::to($this->selectedUser->email)->send(
                new UserRevisionRequested($this->selectedUser, $reason, $revisionUrl)
            );
        } catch (\Throwable $e) {
            \Log::error('Revision request email failed', [
                'user_id' => $this->selectedUser->id,
                'error' => $e->getMessage(),
            ]);
        }

        $this->dispatch('notify', message: 'ส่งคำขอแก้ไขไปยังผู้ใช้แล้ว', type: 'warning');
        $this->closeUserDetail();
    }

    public function rejectAndDelete()
    {
        if (!$this->selectedUser) {
            return;
        }

        $reason = trim((string) $this->adminNote) !== ''
            ? trim((string) $this->adminNote)
            : 'ไม่อนุมัติและลบบัญชี';

        ApprovalLog::create([
            'user_id' => $this->selectedUser->id,
            'action' => 'rejected_deleted',
            'reason' => $reason,
            'acted_by' => auth()->id(),
            'meta' => [
                'payment_proof_id' => $this->selectedProof?->id,
            ],
        ]);

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
        $this->rejectUser();
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
            ->whereNull('rejection_reason')
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
            // Show rejected users
            $rejectedUsers = User::with(['paymentProofs' => function($q) {
                $q->latest()->limit(1);
            }])
            ->whereNotNull('rejection_reason')
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
