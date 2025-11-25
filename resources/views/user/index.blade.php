@extends('layouts.main')

@section('title', 'User Management | Travel Malang ID')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-header-title">
                    <h5 class="m-b-10">User Management</h5>
                </div>
            </div>
            <div class="col-auto">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">User Management</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<!-- [ Main Content ] start -->
<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User List</h5>
                    <button type="button" class="btn btn-primary" id="addUserBtn">
                        <i class="ti ti-plus"></i> Add User
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>
<!-- [ Main Content ] end -->
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('users.get-data') }}'
            },
            order: [[0, 'asc']],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'users.name' },
                { data: 'email', name: 'users.email' },
                { data: 'created_at', name: 'users.created_at' },
                { data: 'updated_at', name: 'users.updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Add User
        $('#addUserBtn').on('click', function() {
            // Implement your add user modal/form here
            Swal.fire({
                title: 'Add User',
                html: `
                    <input id="swal-name" class="swal2-input" placeholder="Name">
                    <input id="swal-email" class="swal2-input" placeholder="Email">
                    <input id="swal-password" type="password" class="swal2-input" placeholder="Password">
                `,
                showCancelButton: true,
                confirmButtonText: 'Save',
                preConfirm: () => {
                    const name = $('#swal-name').val();
                    const email = $('#swal-email').val();
                    const password = $('#swal-password').val();
                    
                    if (!name || !email || !password) {
                        Swal.showValidationMessage('All fields are required');
                        return false;
                    }
                    
                    return { name, email, password };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('users.store') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name: result.value.name,
                            email: result.value.email,
                            password: result.value.password
                        },
                        success: function(response) {
                            Swal.fire('Success!', response.message, 'success');
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            const errors = xhr.responseJSON.errors;
                            let errorMsg = '';
                            if (errors) {
                                Object.keys(errors).forEach(key => {
                                    errorMsg += errors[key][0] + '<br>';
                                });
                            } else {
                                errorMsg = xhr.responseJSON.message || 'Failed to create user';
                            }
                            Swal.fire('Error!', errorMsg, 'error');
                        }
                    });
                }
            });
        });

        // Edit User
        $(document).on('click', '.edit-btn', function() {
            const userId = $(this).data('id');
            
            $.ajax({
                url: '{{ url('users') }}/' + userId,
                type: 'GET',
                success: function(response) {
                    Swal.fire({
                        title: 'Edit User',
                        html: `
                            <input id="swal-name" class="swal2-input" placeholder="Name" value="${response.data.name}">
                            <input id="swal-email" class="swal2-input" placeholder="Email" value="${response.data.email}">
                            <input id="swal-password" type="password" class="swal2-input" placeholder="Password (leave blank to keep current)">
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Update',
                        preConfirm: () => {
                            const name = $('#swal-name').val();
                            const email = $('#swal-email').val();
                            const password = $('#swal-password').val();
                            
                            if (!name || !email) {
                                Swal.showValidationMessage('Name and Email are required');
                                return false;
                            }
                            
                            return { name, email, password };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ url('users') }}/' + userId,
                                type: 'PUT',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    name: result.value.name,
                                    email: result.value.email,
                                    password: result.value.password
                                },
                                success: function(response) {
                                    Swal.fire('Success!', response.message, 'success');
                                    table.ajax.reload();
                                },
                                error: function(xhr) {
                                    const errors = xhr.responseJSON.errors;
                                    let errorMsg = '';
                                    if (errors) {
                                        Object.keys(errors).forEach(key => {
                                            errorMsg += errors[key][0] + '<br>';
                                        });
                                    } else {
                                        errorMsg = xhr.responseJSON.message || 'Failed to update user';
                                    }
                                    Swal.fire('Error!', errorMsg, 'error');
                                }
                            });
                        }
                    });
                }
            });
        });

        // Delete User
        $(document).on('click', '.delete-btn', function() {
            const userId = $(this).data('id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('users') }}/' + userId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', response.message, 'success');
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', xhr.responseJSON.message || 'Failed to delete user', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

