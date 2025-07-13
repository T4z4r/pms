<?php
namespace App\Exports;

use App\Models\TestCase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TestCaseExport implements FromCollection, WithHeadings, WithMapping
{
    protected $testPlanId;

    public function __construct($testPlanId)
    {
        $this->testPlanId = $testPlanId;
    }

    public function collection()
    {
        return TestCase::where('test_plan_id', $this->testPlanId)->get();
    }

    public function headings(): array
    {
        return [
            'Title',
            'Description',
            'Expected Outcome',
            'Status',
            'Creator',
            'Created At',
        ];
    }

    public function map($testCase): array
    {
        return [
            $testCase->title,
            strip_tags($testCase->description ?? ''),
            strip_tags($testCase->expected_outcome ?? ''),
            ucwords(str_replace('_', ' ', $testCase->status)),
            $testCase->creator->name,
            $testCase->created_at->format('Y-m-d'),
        ];
    }
}
