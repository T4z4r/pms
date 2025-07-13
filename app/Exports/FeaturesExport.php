<?php

namespace App\Exports;

use App\Models\System;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FeaturesExport implements FromArray, WithHeadings
{
    protected $system;

    public function __construct(System $system)
    {
        $this->system = $system;
    }

    public function headings(): array
    {
        return [
            'SN',
            'Title',
            'Description',
            'Module',
            'Submodule',
            'Status',
            'Creator',
            'Created At',
        ];
    }

    public function array(): array
    {
        $data = [
            ['System Name', $this->system->name],
            ['System Description', strip_tags($this->system->description ?? '-')],
            ['', ''], // Spacer row
            $this->headings(),
        ];

        foreach ($this->system->features as $index => $feature) {
            $data[] = [
                $index + 1,
                $feature->title,
                strip_tags($feature->description ?? ''),
                $feature->module?->name ?? 'N/A',
                $feature->submodule?->name ?? 'N/A',
                ucwords(str_replace('_', ' ', $feature->status)),
                $feature->creator?->name ?? '--',
                $feature->created_at->format('Y-m-d H:i'),
            ];
        }

        return $data;
    }
}