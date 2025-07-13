<?php

namespace App\Exports;

use App\Models\System;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequirementsExport implements FromArray, WithHeadings
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
            'Priority',
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

        foreach ($this->system->requirements as $index => $requirement) {
            $data[] = [
                $index + 1,
                $requirement->title,
                strip_tags($requirement->description ?? ''),
                ucwords($requirement->priority),
                ucwords(str_replace('_', ' ', $requirement->status)),
                $requirement->creator?->name ?? '--',
                $requirement->created_at->format('Y-m-d H:i'),
            ];
        }

        return $data;
    }
}