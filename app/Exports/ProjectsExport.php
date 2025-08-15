<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public $projects;

    public function __construct($projects) {
        $this->projects = $projects;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    /**
     * Custom headings
     */
    public function headings(): array {
        return [
            'ID',
            'Project Name',
            'Description',
            'Status',
            'Deadline',
            'Created At'
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Project::whereIn('id', $this->projects)->get([
            'id',
            'name',
            'description',
            'status',
            'deadline',
            'created_at'
        ])->map(function($project) {
            return [
                $project->id,
                $project->name,
                $project->description,
                ucfirst(str_replace('-', ' ', $project->status)),
                $project->deadline,
                $project->created_at->format('Y-m-d')
            ];
        });
    }
}
