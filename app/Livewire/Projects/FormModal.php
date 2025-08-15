<?php
namespace App\Livewire\Projects;

use App\Services\ProjectService;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormModal extends Component
{

    use WithFileUploads;

    #[Validate('required|string|max:100')]
    public $name = null;

    #[Validate('required|string|max:255')]
    public $description = null;

    #[Validate('required|string')]
    public $deadline = null;

    #[Validate('required|string')]
    public $status = 'pending';

    #[Validate('nullable|image|max:5120')]
    public $project_logo = null;

    public $projectId = null;
    public $isView = false;
    public $existingImage = null;

    /**
     * Function: saveProject
     */
    public function saveProject(ProjectService $projectService)
    {

        # Validating form here
        $validatedProjectRequest = $this->validate();

        if ($this->projectId) {
            $projectService->updateProject($this->projectId, $validatedProjectRequest);

        } else {
            $projectService->saveProject($validatedProjectRequest);
        }

        $this->reset();

        $this->dispatch('flash', [
            'message' => 'Project created successfully!',
            'type'    => 'success',
        ]);

        $this->dispatch('refresh-project-listing');

        Flux::modal('project-modal')->close();

    }

    #[On('open-project-modal')]
    public function projectDetail(ProjectService $projectService, $mode, $project = null)
    {
        $this->isView = $mode === 'view';

        if ($mode === 'create') {
            $this->isView = false;
            $this->projectId = null;
            $this->existingImage = null;
            $this->reset();
        } else {


            $projectData = $projectService->getProjectById($project);
            $this->projectId = $project;


            $this->name          = $projectData['name'];
            $this->description   = $projectData['description'];
            $this->deadline      = $projectData['deadline'];
            $this->status        = $projectData['status'];
            $this->existingImage = $projectData['project_logo'];
        }
    }

    public function render()
    {
        return view('livewire.projects.form-modal');
    }
}
