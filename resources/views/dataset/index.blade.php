@extends('layouts.main')

@section('title', 'Dataset Management | Travel Malang ID')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dataset Management</h5>
                </div>
            </div>
            <div class="col-auto">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Dataset Management</li>
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
                    <h5 class="mb-0">Dataset List</h5>
                    <button type="button" class="btn btn-primary" id="addDatasetBtn">
                        <i class="ti ti-plus"></i> Add Dataset
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
                                <th>File Path</th>
                                <th>Created By</th>
                                <th>Created At</th>
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
                url: '{{ route('dataset.get-data') }}'
            },
            order: [[0, 'asc']],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'm_dataset.name' },
                { data: 'file_path', name: 'm_dataset.file_path' },
                { data: 'created_by_name', name: 'cu.name' },
                { data: 'created_at', name: 'm_dataset.created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Add Dataset
        $('#addDatasetBtn').on('click', function() {
            Swal.fire({
                title: 'Add Dataset',
                html: `
                    <input id="swal-name" class="swal2-input" placeholder="Dataset Name">
                    <input id="swal-file" type="file" class="swal2-file" accept=".csv,.txt,.xlsx,.xls">
                `,
                showCancelButton: true,
                confirmButtonText: 'Save',
                preConfirm: () => {
                    const name = $('#swal-name').val();
                    const file = $('#swal-file')[0].files[0];
                    
                    if (!name || !file) {
                        Swal.showValidationMessage('Name and file are required');
                        return false;
                    }
                    
                    return { name, file };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('name', result.value.name);
                    formData.append('file', result.value.file);
                    
                    $.ajax({
                        url: '{{ route('dataset.store') }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
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
                                errorMsg = xhr.responseJSON.message || 'Failed to create dataset';
                            }
                            Swal.fire('Error!', errorMsg, 'error');
                        }
                    });
                }
            });
        });

        // Edit Dataset
        $(document).on('click', '.edit-btn', function() {
            const datasetId = $(this).data('id');
            
            $.ajax({
                url: '{{ url('dataset') }}/' + datasetId,
                type: 'GET',
                success: function(response) {
                    Swal.fire({
                        title: 'Edit Dataset',
                        html: `
                            <input id="swal-name" class="swal2-input" placeholder="Dataset Name" value="${response.data.name}">
                            <input id="swal-file" type="file" class="swal2-file" accept=".csv,.txt,.xlsx,.xls">
                            <small class="text-muted">Leave file blank to keep current file</small>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Update',
                        preConfirm: () => {
                            const name = $('#swal-name').val();
                            const file = $('#swal-file')[0].files[0];
                            
                            if (!name) {
                                Swal.showValidationMessage('Name is required');
                                return false;
                            }
                            
                            return { name, file };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'PUT');
                            formData.append('name', result.value.name);
                            if (result.value.file) {
                                formData.append('file', result.value.file);
                            }
                            
                            $.ajax({
                                url: '{{ url('dataset') }}/' + datasetId,
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
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
                                        errorMsg = xhr.responseJSON.message || 'Failed to update dataset';
                                    }
                                    Swal.fire('Error!', errorMsg, 'error');
                                }
                            });
                        }
                    });
                }
            });
        });

        // Delete Dataset
        $(document).on('click', '.delete-btn', function() {
            const datasetId = $(this).data('id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "This will soft delete the dataset!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('dataset') }}/' + datasetId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', response.message, 'success');
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', xhr.responseJSON.message || 'Failed to delete dataset', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

