<!DOCTYPE html>
<html>

<head>
    <title>Standard Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            margin: 20px 0;
        }

        .section {
            margin-bottom: 15px;
        }

        .label {
            font-weight: bold;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Standard Details</h2>
    </div>

    <div class="content">
        <div class="section">
            <span class="label">Name:</span> {{ $standard->name }}
        </div>
        <div class="section">
            <span class="label">Compliance Status:</span>
            <span
                class="badge badge-{{ $standard->compliance_status === 'compliant' ? 'success' : ($standard->compliance_status === 'non_compliant' ? 'danger' : ($standard->compliance_status === 'partially_compliant' ? 'warning' : 'secondary')) }}">
                {{ ucwords(str_replace('_', ' ', $standard->compliance_status)) }}
            </span>
        </div>
        <div class="section">
            <span class="label">Creator:</span> {{ $creator }}
        </div>
        <div class="section">
            <span class="label">Updated By:</span> {{ $updater }}
        </div>
        <div class="section">
            <span class="label">Created At:</span> {{ $created_at }}
        </div>
        <div class="section">
            <span class="label">Description:</span>
            <div>{!! $standard->description !!}</div>
        </div>
    </div>
</body>

</html>
