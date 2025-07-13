<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Plan: {{ $testPlan->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { font-size: 18px; }
        h2 { font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .badge { display: inline-block; padding: 4px 8px; color: #fff; }
    </style>
</head>
<body>
    <h1>Test Plan: {{ $testPlan->title }}</h1>
    <p><strong>Description:</strong> {!! $testPlan->description ?? '-' !!}</p>
    <p><strong>Project:</strong> {{ $testPlan->project->name }}</p>
    <p><strong>Start Date:</strong> {{ $testPlan->start_date->format('Y-m-d H:i') }}</p>
    <p><strong>End Date:</strong> {{ $testPlan->end_date?->format('Y-m-d H:i') ?? '-' }}</p>
    <p><strong>Color:</strong> <span class="badge" style="background-color: {{ $testPlan->color }}">{{ $testPlan->color }}</span></p>
    <p><strong>Creator:</strong> {{ $testPlan->creator->name }}</p>
    <p><strong>Assignee:</strong> {{ $testPlan->assignee?->name ?? '-' }}</p>
    <p><strong>Created At:</strong> {{ $testPlan->created_at->format('Y-m-d') }}</p>

    <h2>Test Cases</h2>
    <table>
        <thead>
            <tr>
                <th>SN.</th>
                <th>Title</th>
                <th>Description</th>
                <th>Expected Outcome</th>
                <th>Status</th>
                <th>Creator</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($testPlan->testCases as $index => $testCase)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $testCase->title }}</td>
                    <td>{!! $testCase->description ?? '-' !!}</td>
                    <td>{!! $testCase->expected_outcome ?? '-' !!}</td>
                    <td>{{ ucwords(str_replace('_', ' ', $testCase->status)) }}</td>
                    <td>{{ $testCase->creator->name }}</td>
                    <td>{{ $testCase->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No test cases found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
