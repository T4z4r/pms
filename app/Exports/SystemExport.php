<?php
namespace App\Exports;

use App\Models\System;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SystemExport implements FromCollection, WithHeadings, WithMapping
{
    protected $systemId;

    public function __construct($systemId)
    {
        $this->systemId = $systemId;
    }

    public function collection()
    {
        $system = System::with('features', 'requirements')->findOrFail($this->systemId);
        $data = collect([$system]);
        $data = $data->merge($system->features);
        $data = $data->merge($system->requirements);
        return $data;
    }

    public function headings(): array
    {
        return [
            'Type',
            'Title/Name',
            'Description',
            'Status',
            'Priority',
            'Creator',
            'Created At',
        ];
    }

    public function map($item): array
    {
        if ($item instanceof \App\Models\System) {
            return [
                'System',
                $item->name,
                strip_tags($item->description ?? ''),
                ucwords(str_replace('_', ' ', $item->status)),
                '',
                $item->creator?->name??'--',
                $item->created_at->format('Y-m-d'),
            ];
        } elseif ($item instanceof \App\Models\Feature) {
            return [
                'Feature',
                $item->title,
                strip_tags($item->description ?? ''),
                ucwords(str_replace('_', ' ', $item->status)),
                '',
                $item->creator?->name??'--',
                $item->created_at->format('Y-m-d'),
            ];
        } elseif ($item instanceof \App\Models\Requirement) {
            return [
                'Requirement',
                $item->title,
                strip_tags($item->description ?? ''),
                ucwords(str_replace('_', ' ', $item->status)),
                ucwords($item->priority),
                $item->creator?->name??'--',
                $item->created_at->format('Y-m-d'),
            ];
        }
        return [];
    }
}