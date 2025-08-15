<?php
namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Function: saveProject
     * @param array $projectRequest
     */
    public function saveProject($projectRequest)
    {
        return Project::create($projectRequest);
    }

    /**
     * Function: getProjectQuery
     */
    public function getProjectQuery()
    {
        return Project::query();
    }
}
