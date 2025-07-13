<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Requirements Export: {{ $system->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h1 {
            font-size: 18px;
            color: #333;
        }

        h2 {
            font-size: 14px;
            color: #555;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .section {
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Requirements for System: {{ $system->name }}</h1>

    <div class="section">
        <h2>System Details</h2>
        <table>
            <tr>
                <td class="label">Name</td>
                <td>{{ $system->name }}</td>
            </tr>
            <tr>
                <td class="label">Description</td>
                <td>{!! $system->description ?? '-' !!}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Requirements</h2>
        @if ($system->requirements->isEmpty())
            <p>No requirements found.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Creator</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($system->requirements as $index => $requirement)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $requirement->title }}</td>
                            <td>{!! $requirement->description ?? '-' !!}</td>
                            <td>{{ ucwords($requirement->priority) }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $requirement->status)) }}</td>
                            <td>{{ $requirement->creator?->name ?? '--' }}</td>
                            <td>{{ $requirement->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>

</html>
