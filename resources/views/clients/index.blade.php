@extends('layouts.vertical', ['title' => 'Client Management'])

@push('head-script')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-header">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center ">
                <h4 class="lead text-primary">
                    <i class="ph-users me-2"></i> Client Management</h4>
                <div>
                    <a href="#" class="btn btn-main btn-sm" data-bs-toggle="modal" data-bs-target="#addClientModal">
                        <i class="ph-plus me-2"></i> New Client
                    </a>
                </div>
            </div>
        </div>



        <div class="card-body shadow-sm">
             <!-- Statistics Widgets -->
        <div class="row ">
            <div class="col-lg-6 col-md-6 mb-3">
                <div class="card bg-primary text-white shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="ph-users display-6 me-3"></i>
                        <div>
                            <p class="title mb-0">Total Clients</p>
                            <p class="card-text h2 mb-0">{{ $totalClients }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mb-3">
                <div class="card bg-success text-white shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="ph-briefcase display-6 me-3"></i>
                        <div>
                            <p class="title mb-0">Clients with Projects</p>
                            <p class="card-text h2 mb-0">{{ $clientsWithProjects }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clients Table -->
        @if (session('msg'))
            <div class="alert alert-success col-md-8 mx-auto" role="alert">
                {{ session('msg') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger col-md-8 mx-auto" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Clients</h5>
            </div>
            <div class="card-body">
                <table id="clientsTable" class="table table-striped table-bordered datatable-basic">
                    <thead>
                        <tr>
                            <th>SN.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Projects</th>
                            <th>Creator</th>
                            <th>Updated By</th>
                            <th>Created At</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $index => $client)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone ?: '-' }}</td>
                                <td>{{ $client->projects->pluck('name')->implode(', ') ?: '-' }}</td>
                                <td>{{ $client->creator->name }}</td>
                                <td>{{ $client->updater ? $client->updater->name : '-' }}</td>
                                <td>{{ $client->created_at->format('Y-m-d H:i') }}</td>
                                <td width="15%">
                                    <a href="#" title="Edit Client" class="btn btn-sm btn-main me-1"
                                        data-bs-toggle="modal" data-bs-target="#editClientModal{{ $client->id }}">
                                        <i class="ph-note-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0)" title="Delete Client" class="btn btn-sm btn-danger me-1"
                                        onclick="deleteClient({{ $client->id }})">
                                        <i class="ph-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No clients found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Client Modal -->
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('clients.store') }}" id="addClientForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addClientModalLabel">Add Client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="Enter client name" required>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                placeholder="Enter client email" required>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                                placeholder="Enter client phone">

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Enter client address">{{ old('address') }}</textarea>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Client</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Client Modal -->
    @foreach ($clients as $client)
        <div class="modal fade" id="editClientModal{{ $client->id }}" tabindex="-1"
            aria-labelledby="editClientModalLabel{{ $client->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" action="{{ route('clients.update', $client) }}"
                        id="editClientForm{{ $client->id }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editClientModalLabel{{ $client->id }}">Edit Client:
                                {{ $client->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $client->name) }}" placeholder="Enter client name" required>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $client->email) }}" placeholder="Enter client email" required>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ old('phone', $client->phone) }}" placeholder="Enter client phone">

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Enter client address">{{ old('address', $client->address) }}</textarea>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Update Client</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <style>
        .card {
            border: none;
            border-radius: 8px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            border-bottom: 1px solid #e9ecef;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
    </style>

    @push('footer-script')
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: 'Select a system',
                    allowClear: true,
                    width: '100%'
                });

                window.deleteClient = function(id) {
                    Swal.fire({
                        title: 'Confirm Deletion',
                        text: 'Are you sure you want to delete this client? This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                    url: "{{ route('clients.destroy', ':id') }}".replace(':id', id),
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                })
                                .done(function() {
                                    Swal.fire('Deleted!', 'Client has been deleted successfully.',
                                        'success');
                                    setTimeout(() => location.reload(), 500);
                                })
                                .fail(function(xhr) {
                                    Swal.fire('Failed!', 'Client deletion failed: ' + (xhr.responseJSON
                                        ?.error || 'Unknown error'), 'error');
                                });
                        }
                    });
                };
            });
        </script>
    @endpush
@endsection
