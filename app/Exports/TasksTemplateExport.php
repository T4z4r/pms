<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TasksTemplateExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * Return an empty collection for the Excel template.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect([]);
    }

    /**
     * Define the column headings for the Excel template.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Title',
            'Description',
            'Project ID',
            'Due Date (YYYY-MM-DD)',
            'Assigned User IDs (comma-separated)',
        ];
    }

    /**
     * Apply styles to the Excel worksheet, including column widths and brand-colored header.
     *
     * @param Worksheet $worksheet
     * @return array
     */
    public function styles(Worksheet $worksheet): array
    {
        // Set column widths for better readability
        $worksheet->getColumnDimension('A')->setWidth(25); // Title
        $worksheet->getColumnDimension('B')->setWidth(45); // Description
        $worksheet->getColumnDimension('C')->setWidth(15); // Project ID
        $worksheet->getColumnDimension('D')->setWidth(20); // Due Date
        $worksheet->getColumnDimension('E')->setWidth(35); // Assigned User IDs

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
