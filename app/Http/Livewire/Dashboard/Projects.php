<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Project;
use App\Models\User;
use App\Mail\ProjectCreatedNotification;

class Projects extends Component
{
    use WithPagination;

    public $showCreateModal = false;

    public $search = '';
    public $filterStatus = '';
    public $filterFreelance = [];
    public $filterCustomer = [];
    public $freelanceSearch = '';
    public $customerSearch = '';
    public $showFreelanceDropdown = false;
    public $showCustomerDropdown = false;

    // Project form fields
    public $name;
    public $description;
    public $status = 'active';
    public $selectedCustomers = [];
    public $customerSearchQuery = '';

    protected $queryString = ['search', 'filterStatus', 'filterFreelance', 'filterCustomer'];

    public function updated($property)
    {
        if (in_array($property, ['search', 'filterStatus', 'filterFreelance', 'filterCustomer'])) {
            $this->resetPage();
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterStatus = '';
        $this->filterFreelance = [];
        $this->filterCustomer = [];
        $this->freelanceSearch = '';
        $this->customerSearch = '';
        $this->resetPage();
    }

    public function toggleFreelanceDropdown()
    {
        $this->showFreelanceDropdown = !$this->showFreelanceDropdown;
    }

    public function toggleCustomerDropdown()
    {
        $this->showCustomerDropdown = !$this->showCustomerDropdown;
    }

    public function toggleFreelanceFilter($id)
    {
        if (in_array($id, $this->filterFreelance)) {
            $this->filterFreelance = array_diff($this->filterFreelance, [$id]);
        } else {
            $this->filterFreelance[] = $id;
        }
    }

    public function toggleCustomerFilter($id)
    {
        if (in_array($id, $this->filterCustomer)) {
            $this->filterCustomer = array_diff($this->filterCustomer, [$id]);
        } else {
            $this->filterCustomer[] = $id;
        }
    }

    public function searchCustomers()
    {
        // Just trigger re-render with current search query
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,completed,on_hold,cancelled',
            'selectedCustomers' => 'array',
        ];
    }

    public function createProject()
    {
        // Prevent customers from creating projects
        if (Auth::user()->role === 'customer') {
            $this->dispatch('notify', message: 'Customers cannot create projects.', type: 'error');
            return;
        }

        try {
            $this->validate();

            $project = Project::create([
                'name' => $this->name,
                'description' => $this->description,
                'status' => $this->status,
                'created_by' => Auth::id(),
            ]);

            // Add customers
            if (!empty($this->selectedCustomers)) {
                $project->customers()->sync($this->selectedCustomers);
                
                // Send email notification to each customer
                $customers = User::whereIn('id', $this->selectedCustomers)->get();
                foreach ($customers as $customer) {
                    try {
                        Mail::to($customer->email)->send(new ProjectCreatedNotification($project->load(['creator', 'freelance', 'customers', 'tasks']), $customer));
                    } catch (\Exception $mailException) {
                        \Log::error('Failed to send project notification email to ' . $customer->email . ': ' . $mailException->getMessage());
                    }
                }
            }

            $this->dispatch('notify', message: 'Project created successfully!', type: 'success');
            $this->resetForm();
            $this->showCreateModal = false;
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to create project. ' . $e->getMessage(), type: 'error');
        }
    }



    protected function resetForm()
    {
        $this->name = null;
        $this->description = null;
        $this->status = 'active';
        $this->selectedCustomers = [];
    }

    public function render()
    {
        $user = Auth::user();
        $query = Project::query();

        // Filter by role
        if ($user->role === 'freelance') {
            // Freelancers see projects they created OR projects assigned to them
            $query->where(function ($q) use ($user) {
                $q->where('created_by', $user->id)
                  ->orWhere('freelance_id', $user->id);
            });
        } elseif ($user->role === 'customer') {
            // Customers see projects they're associated with
            $query->whereHas('customers', function ($q) use ($user) {
                $q->where('customer_id', $user->id);
            });
        }
        // Admin sees all projects

        // Search filter
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        // Status filter
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        // Freelancer filter (multiple)
        if (!empty($this->filterFreelance)) {
            $query->whereIn('freelance_id', $this->filterFreelance);
        }

        // Customer filter (multiple)
        if (!empty($this->filterCustomer)) {
            $query->whereHas('customers', function ($q) {
                $q->whereIn('customer_id', $this->filterCustomer);
            });
        }

        $projects = $query->with('creator', 'freelance', 'customers')->paginate(12);

        // Get available freelancers and customers for filter dropdowns
        $allFreelancers = User::where('role', 'freelance')->where('is_approved', true)->get();
        $allCustomers = User::where('role', 'customer')->where('is_approved', true)->get();

        // Filter lists based on search
        $freelancers = $allFreelancers->filter(function ($f) {
            return empty($this->freelanceSearch) || stripos($f->name, $this->freelanceSearch) !== false || stripos($f->email, $this->freelanceSearch) !== false;
        });
        $customers = $allCustomers->filter(function ($c) {
            return empty($this->customerSearch) || stripos($c->name, $this->customerSearch) !== false || stripos($c->email, $this->customerSearch) !== false;
        });

        $hasActiveFilters = $this->search || $this->filterStatus || !empty($this->filterFreelance) || !empty($this->filterCustomer);

        return view('livewire.dashboard.projects', [
            'projects' => $projects,
            'customers' => $allCustomers->when($this->customerSearchQuery, function($collection) {
                return $collection->filter(function($customer) {
                    return stripos($customer->email, $this->customerSearchQuery) !== false || 
                           stripos($customer->name, $this->customerSearchQuery) !== false;
                });
            }),
            'freelancers' => $allFreelancers,
            'filteredFreelancers' => $freelancers,
            'filteredCustomers' => $customers,
            'hasActiveFilters' => $hasActiveFilters,
        ]);
    }
}
