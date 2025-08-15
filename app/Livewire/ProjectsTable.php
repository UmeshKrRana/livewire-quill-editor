<?php
namespace App\Livewire;

use App\Models\Project;
use App\Exports\ProjectsExport;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;

class ProjectsTable extends DataTableComponent
{
    protected $model = Project::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setEmptyMessage('No Data Found!');
        $this->setPerPageAccepted([5, 10, 25, 50, 100]);
        $this->setDefaultPerPage(5);
        $this->setQueryStringDisabled();
        $this->setBulkActions([
            'exportedSelected' => 'Export to Excel',
            'pdf' => 'Export to PDF'
        ]);
    }

    /**
     * Function to export selected to excel
     */
    public function exportedSelected()
    {
        $projects = $this->getSelected();

        return Excel::download(new ProjectsExport($projects), 'projects.xlsx');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->searchable(),

            Column::make("Name", "name")
                ->sortable()
                ->searchable(),

            Column::make("Description", "description")
                ->sortable()
                ->searchable(),

            Column::make("Deadline", "deadline")
                ->sortable()
                ->searchable(),

            // status column
            Column::make("Status", "status")
                ->sortable()
                ->searchable()
                ->format(
                    fn($value, $row, Column $column) => $this->renderStatus($value)
                )
                ->html(),

            // Project logo
            Column::make("Project Logo", "project_logo")->hideIf(true),
            ImageColumn::make("Project logo", "project_logo")
                ->location(
                    fn($row) => asset('storage/' . $row->project_logo)
                )
                ->sortable(),

            // Action column
            Column::make('Action')
                ->label(
                    fn($row, Column $column) => view('livewire.projects.action-columns')->with(['project' => $row])
                )
                ->html(),

        ];
    }

    public function renderStatus(string $status): string
    {
        $colors = [
            'pending'     => 'bg-yellow-300 text-yellow-800 border border-yellow-500',
            'in-progress' => 'bg-blue-300 text-blue-800 border border-blue-500',
            'completed'   => 'bg-green-300 text-green-800 border border-green-500',
            'cancelled'   => 'bg-red-300 text-red-800 border border-red-500',
        ];

        $class = $colors[$status] ?? 'bg-gray-300 text-gray-800 border-gray-500';

        $label = ucfirst(str_replace('-', ' ', $status));
        return "<span class=\"px-3 py-1 rounded shadow-sm ${class}\">{$label}</span>";
    }
}
