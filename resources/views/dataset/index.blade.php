@extends('layouts.main')

@section('title', 'Dataset Management | Travel Malang ID')

@section('content')
<style>
    /* HTML: <div class="loader"></div> */
    .loader-inner {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .loader-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
    }
    .loader {
        width: 50px;
        aspect-ratio: 1;
        display: grid;
        border: 4px solid #0000;
        border-radius: 50%;
        border-color: #ccc #0000;
        animation: l16 1s infinite linear;
    }
    .loader::before,
    .loader::after {    
        content: "";
        grid-area: 1/1;
        margin: 2px;
        border: inherit;
        border-radius: 50%;
    }
    .loader::before {
        border-color: #f03355 #0000;
        animation: inherit; 
        animation-duration: .5s;
        animation-direction: reverse;
    }
    .loader::after {
        margin: 8px;
    }
    @keyframes l16 { 
        100%{transform: rotate(1turn)}
    }
</style>
<div class="loader-container" id="loaderNew">
    <div class="loader-inner">
        <div class="loader"></div>
    </div>
</div>
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

<!-- Add Dataset Modal -->
<div class="modal fade" id="addDatasetModal" tabindex="-1" aria-labelledby="addDatasetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDatasetModalLabel">Add Dataset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addDatasetForm" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="add-name" class="form-label">Dataset Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="add-name" name="name" placeholder="Enter dataset name" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="add-file" class="form-label">Upload File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="add-file" name="file" accept=".pdf" required>
                        <div class="form-text">Accepted formats: PDF</div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Dataset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Dataset Modal -->
<div class="modal fade" id="editDatasetModal" tabindex="-1" aria-labelledby="editDatasetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDatasetModalLabel">Edit Dataset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editDatasetForm" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-dataset-id" name="dataset_id">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Dataset Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit-name" name="name" placeholder="Enter dataset name" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-file" class="form-label">Upload File</label>
                        <input type="file" class="form-control" id="edit-file" name="file" accept=".csv,.txt,.xlsx,.xls">
                        <div class="form-text">Leave empty to keep current file. Accepted formats: CSV, TXT, XLSX, XLS</div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Dataset</button>
                </div>
            </form>
        </div>
    </div>
</div>
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

        // Show Add Dataset Modal
        $('#addDatasetBtn').on('click', function() {
            $('#addDatasetForm')[0].reset();
            $('#addDatasetForm .is-invalid').removeClass('is-invalid');
            $('#addDatasetModal').modal('show');
        });

        // Handle Add Dataset Form Submit
        $('#addDatasetForm').on('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            $('#addDatasetModal').modal('hide');
            $('#loaderNew').show();
            $.ajax({
                url: '{{ route('dataset.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#loaderNew').hide();
                    $('#addDatasetModal').modal('hide');
                    Swal.fire('Success!', response.message, 'success');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    $('#loaderNew').hide();
                    // $('#addDatasetModal').modal('hide');
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        // Clear previous errors
                        $('#addDatasetForm .is-invalid').removeClass('is-invalid');
                        $('#addDatasetForm .invalid-feedback').text('');
                        
                        // Show validation errors
                        Object.keys(errors).forEach(key => {
                            const input = $('#add-' + key);
                            input.addClass('is-invalid');
                            input.siblings('.invalid-feedback').text(errors[key][0]);
                        });
                    } else {
                        Swal.fire('Error!', xhr.responseJSON.message || 'Failed to create dataset', 'error');
                    }
                }
            });
        });

        // Show Edit Dataset Modal
        $(document).on('click', '.edit-btn', function() {
            const datasetId = $(this).data('id');
            
            $.ajax({
                url: '{{ url('dataset') }}/' + datasetId,
                type: 'GET',
                success: function(response) {
                    $('#edit-dataset-id').val(datasetId);
                    $('#edit-name').val(response.data.name);
                    $('#editDatasetForm .is-invalid').removeClass('is-invalid');
                    $('#editDatasetForm .invalid-feedback').text('');
                    $('#editDatasetModal').modal('show');
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'Failed to load dataset data', 'error');
                }
            });
        });

        // Handle Edit Dataset Form Submit
        $('#editDatasetForm').on('submit', function(e) {
            e.preventDefault();
            
            const datasetId = $('#edit-dataset-id').val();
            const formData = new FormData(this);
            formData.append('_method', 'PUT');
            
            $.ajax({
                url: '{{ url('dataset') }}/' + datasetId,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editDatasetModal').modal('hide');
                    Swal.fire('Success!', response.message, 'success');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        // Clear previous errors
                        $('#editDatasetForm .is-invalid').removeClass('is-invalid');
                        $('#editDatasetForm .invalid-feedback').text('');
                        
                        // Show validation errors
                        Object.keys(errors).forEach(key => {
                            const input = $('#edit-' + key);
                            input.addClass('is-invalid');
                            input.siblings('.invalid-feedback').text(errors[key][0]);
                        });
                    } else {
                        Swal.fire('Error!', xhr.responseJSON.message || 'Failed to update dataset', 'error');
                    }
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

