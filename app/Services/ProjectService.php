<?php
namespace App\Services;

use App\Repositories\ProjectRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectService
{
    protected $projectRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function saveProject($projectRequest)
    {

        if (! empty($projectRequest['project_logo'])) {

            $projectLogo = $projectRequest['project_logo'];

            # Upload project image
            $projectLogoPath = $projectLogo->store('projects', 'public');

            $projectRequest['project_logo'] = $projectLogoPath;
        }

        $projectRequest['slug'] = Str::slug($projectRequest['name']);

        return $this->projectRepository->saveProject($projectRequest);

    }

    public function getProjectById($projectId)
    {
        return $this->getAllProjects()->find($projectId);
    }

    /**
     * Function: getAllProjects
     */
    public function getAllProjects()
    {
        return $this->projectRepository->getProjectQuery();
    }

    /**
     * Function: updateProject
     * @param int $projectId
     * @param array $projectRequest
     */
    public function updateProject($projectId, $projectRequest)
    {
        $project = $this->getAllProjects()->find($projectId);

        if ($project) {

            if (! empty($projectRequest['project_logo'])) {

                $projectLogo = $projectRequest['project_logo'];

                # Upload project image
                $projectLogoPath = $projectLogo->store('projects', 'public');

                $projectRequest['project_logo'] = $projectLogoPath;

                if ($project->project_logo && Storage::exists($project->project_logo)) {
                    Storage::delete($project->project_logo);
                }

                $project->project_logo = $projectLogoPath;
            }

            $project->name        = $projectRequest['name'];
            $project->slug        = Str::slug($projectRequest['name']);
            $project->description = $projectRequest['description'];
            $project->status      = $projectRequest['status'];
            $project->deadline    = $projectRequest['deadline'];

            return $project->save();
        }
    }

    /**
     * Function: deleteProject
     * @param int $projectId
     */
    public function deleteProject($projectId)
    {
        $project = $this->getAllProjects()->find($projectId);

        if ($project) {
            return $project->delete();
        }
    }
}
