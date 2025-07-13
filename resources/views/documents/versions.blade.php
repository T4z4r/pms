@extends('layouts.vertical', ['title' => 'Document Versions'])

@section('content')
<div class="card border-top border-top-width-3 border-top-black rounded-0">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="lead text-primary">
                <i class="ph-file-text text-secondary"></i> Versions for {{ $document->title }}
            </h4>
            <div>
                <a href="{{ route('documents.index') }}" class="btn btn-brand btn-sm">
                    <i class="ph-arrow-left me-2"></i> Back to Documents
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Version</th>
                    <th>Content</th>
                    <th>File</th>
                    <th>Created By</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($document->versions as $version)
                    <tr>
                        <td>{{ $version->version_number }}</td>
                        <td>{!! Str::limit(strip_tags($version->content ?? ''), 50) !!}</td>
                        <td>
                            @if ($version->file_path)
                                <a href="{{ Storage::url($version->file_path) }}" target="_blank">Download</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $version->creator->name }}</td>
                        <td>{{ $version->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No versions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
