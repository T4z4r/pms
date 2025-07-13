<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectTasksExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $projectId;

    public function __construct($projectId)
    {
        $this->projectId = $projectId;
    }

    public function collection()
    {
        return Task::with(['project', 'creator', 'users'])
            ->where('project_id', $this->projectId)
            ->get();
    }

    public function headings(): array
    {
        return [
            'Title',
            'Description',
            'Project',
            // 'Creator',
            'Status',
            'Due Date',
            'Assigned Users',
        ];
    }

    public function map($task): array
    {
        return [
            $task->title,
            strip_tags($task->description),
            $task->project->name ?? 'N/A',
            $task->creator->name,
            ucfirst($task->status),
            $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'N/A',
            $task->users->pluck('name')->implode(', ') ?: 'None',
        ];
    }

    public function styles(Worksheet $worksheet): array
    {
        // Set column widths for better readability
        $worksheet->getColumnDimension('A')->setWidth(25); // Title
        $worksheet->getColumnDimension('B')->setWidth(45); // Description
        $worksheet->getColumnDimension('C')->setWidth(15); // Project
        // $worksheet->getColumnDimension('D')->setWidth(20); // Creator
        $worksheet->getColumnDimension('D')->setWidth(15); // Status
        $worksheet->getColumnDimension('E')->setWidth(20); // Due Date
        $worksheet->getColumnDimension('F')->setWidth(35); // Assigned Users

        // Apply styles to the header row using brand colors
        return [
            // Style the first row (headings)
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'], // White text
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF1D5FC9'], // Brand primary color (#1d5fc9)
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'], // Black borders
                    ],
                ],
            ],
        ];
    }
}
