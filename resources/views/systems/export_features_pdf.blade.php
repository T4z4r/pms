<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title> {{ $system->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ public_path('assets/images/flex-logo.png') }}') no-repeat center;
            background-size: 50%;
            opacity: 0.08;
            z-index: -1;
        }

        h1 {
            font-size: 18px;
            color: #1d5fc9;
            text-align: center;
        }

        h2 {
            font-size: 14px;
            color: #1d5fc9;
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
            background-color: #1d5fc9;
            color: white !important;
            font-weight: bold;
        }

        th:hover,
        td:hover {
            background-color: #a3cfee;
        }

        .section {
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
            background-color: #1d5fc9;
            color: white !important;
        }

        .table-primary td {
            background-color: #e9ecef;
            font-weight: bold;
        }

        hr {
            margin: 10px 0;
            border: 0;
            border-top: 1px solid #ccc;
        }

        .logo-container {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .logo-container img {
            width: 100px;
            height: auto;
        }

        .footer-stripes {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 20px;
            background: repeating-linear-gradient(0deg,
                    #1d5fc9 0px 5px,
                    #05aeee 5px 10px);
        }

        .cover-page {
            page-break-after: always;
            text-align: center;
            padding-top: 100px;
            height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .cover-page h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .cover-page img {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Cover Page -->
    <div class="cover-page">
        <img src="{{ public_path('assets/images/flex-logo.png') }}" alt="Logo">
        <h1> {{ $system->name }}</h1>
        <p>Generated on {{ date('F d, Y') }}</p>
    </div>

    <!-- Original Content -->
    {{-- <div class="logo-container">
        <img src="{{ public_path('assets/images/flex-logo.png') }}" alt="Logo">
    </div>

    <h1>Features for System: {{ $system->name }}</h1>
    <hr> --}}
    <div class="section" sytle="margin-top: 20px;">
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
        <h2>Features</h2>
        <hr>

        @php
            $groupedFeatures = $system->features
                ->sortBy('module.order')
                ->groupBy(fn($f) => $f->module->name ?? 'Uncategorized');
            $rowIndex = 1;
        @endphp

        @if ($groupedFeatures->isEmpty())
            <p>No features found.</p>
        @else
            <table id="featuresTable">
                <thead>
                    <tr>
                        <th>SN.</th>
                        <th>Submodule</th>
                        <th>Title</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groupedFeatures as $moduleName => $features)
                        <tr class="table-primary">
                            <td colspan="4">{{ $moduleName }}</td>
                        </tr>
                        @foreach ($features as $feature)
                            <tr>
                                <td>{{ $rowIndex++ }}</td>
                                <td>{{ $feature->submodule->name ?? ' ' }}</td>
                                <td>{{ $feature->title }}</td>
                                <td width="40%">{!! $feature->description ?? '' !!}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">No features found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>

    <div class="footer-stripes"></div>
</body>

</html>
