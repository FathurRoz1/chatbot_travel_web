@extends('layouts.main')

@section('title', 'Dashboard | Travel Malang ID')

@section('content')
<!-- [ Main Content ] start -->
<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-xl-4 col-md-6">
        <div class="card bg-secondary-dark dashnum-card text-white overflow-hidden">
            <span class="round small"></span>
            <span class="round big"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="avtar avtar-lg">
                            <i class="text-white ti ti-message-chatbot"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="btn-group">
                            <a href="#" class="avtar avtar-s bg-secondary text-white dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item">View Details</button></li>
                                <li><button class="dropdown-item">Export Report</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <span class="text-white d-block f-34 f-w-500 my-2">
                    2,547
                    <i class="ti ti-arrow-up-right-circle opacity-50"></i>
                </span>
                <p class="mb-0 opacity-50">Total Chat Sessions</p>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card bg-primary-dark dashnum-card text-white overflow-hidden">
            <span class="round small"></span>
            <span class="round big"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="avtar avtar-lg">
                            <i class="text-white ti ti-chart-line"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <ul class="nav nav-pills justify-content-end mb-0" id="chart-tab-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-white active" id="chart-tab-home-tab" data-bs-toggle="pill" data-bs-target="#chart-tab-home" role="tab" aria-controls="chart-tab-home" aria-selected="true">
                                    Week
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-white" id="chart-tab-profile-tab" data-bs-toggle="pill" data-bs-target="#chart-tab-profile" role="tab" aria-controls="chart-tab-profile" aria-selected="false">
                                    Month
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content" id="chart-tab-tabContent">
                    <div class="tab-pane show active" id="chart-tab-home" role="tabpanel" aria-labelledby="chart-tab-home-tab" tabindex="0">
                        <div class="row">
                            <div class="col-6">
                                <span class="text-white d-block f-34 f-w-500 my-2">
                                    385
                                    <i class="ti ti-arrow-up-right-circle opacity-50"></i>
                                </span>
                                <p class="mb-0 opacity-50">Weekly Usage</p>
                            </div>
                            <div class="col-6">
                                <div id="tab-chart-1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="chart-tab-profile" role="tabpanel" aria-labelledby="chart-tab-profile-tab" tabindex="0">
                        <div class="row">
                            <div class="col-6">
                                <span class="text-white d-block f-34 f-w-500 my-2">
                                    1,654
                                    <i class="ti ti-arrow-up-right-circle opacity-50"></i>
                                </span>
                                <p class="mb-0 opacity-50">Monthly Usage</p>
                            </div>
                            <div class="col-6">
                                <div id="tab-chart-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-12">
        <div class="card bg-success-dark dashnum-card dashnum-card-small text-white overflow-hidden">
            <span class="round bg-success small"></span>
            <span class="round bg-success big"></span>
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="avtar avtar-lg">
                        <i class="text-white ti ti-target"></i>
                    </div>
                    <div class="ms-2">
                        <h4 class="text-white mb-1">91.5%</h4>
                        <p class="mb-0 opacity-75 text-sm">Average Accuracy</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card dashnum-card dashnum-card-small overflow-hidden">
            <span class="round bg-info small"></span>
            <span class="round bg-info big"></span>
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="avtar avtar-lg bg-light-info">
                        <i class="text-info ti ti-clock"></i>
                    </div>
                    <div class="ms-2">
                        <h4 class="mb-1">1.8s</h4>
                        <p class="mb-0 opacity-75 text-sm">Avg Response Time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <div class="col">
                        <small class="text-muted">Chatbot Usage Frequency</small>
                        <h3>2,547 Interactions</h3>
                    </div>
                    <div class="col-auto">
                        <select class="form-select p-r-35">
                            <option>Today</option>
                            <option selected>This Month</option>
                            <option>This Year</option>
                        </select>
                    </div>
                </div>
                <div id="growthchart"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <div class="col">
                        <h4>Chatbot Accuracy</h4>
                    </div>
                    <div class="col-auto"></div>
                </div>
                <div class="rounded bg-light-success overflow-hidden mb-3">
                    <div class="px-3 pt-3">
                        <div class="row mb-1 align-items-start">
                            <div class="col">
                                <h5 class="text-success mb-0">Weekly Accuracy</h5>
                                <small class="text-muted">Last 7 Days</small>
                            </div>
                            <div class="col-auto">
                                <h4 class="mb-0">91.5%</h4>
                            </div>
                        </div>
                    </div>
                    <div id="bajajchart"></div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0">
                        <div class="row align-items-start">
                            <div class="col">
                                <h5 class="mb-0">Travel Info Queries</h5>
                                <small class="text-success">95% Accuracy</small>
                            </div>
                            <div class="col-auto">
                                <h4 class="mb-0">
                                    95%
                                    <span class="ms-2 align-top avtar avtar-xxs bg-light-success">
                                        <i class="ti ti-chevron-up text-success"></i>
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-0">
                        <div class="row align-items-start">
                            <div class="col">
                                <h5 class="mb-0">Booking Assistance</h5>
                                <small class="text-success">92% Accuracy</small>
                            </div>
                            <div class="col-auto">
                                <h4 class="mb-0">
                                    92%
                                    <span class="ms-2 align-top avtar avtar-xxs bg-light-success">
                                        <i class="ti ti-chevron-up text-success"></i>
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-0">
                        <div class="row align-items-start">
                            <div class="col">
                                <h5 class="mb-0">General Questions</h5>
                                <small class="text-success">88% Accuracy</small>
                            </div>
                            <div class="col-auto">
                                <h4 class="mb-0">
                                    88%
                                    <span class="ms-2 align-top avtar avtar-xxs bg-light-success">
                                        <i class="ti ti-chevron-up text-success"></i>
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-0">
                        <div class="row align-items-start">
                            <div class="col">
                                <h5 class="mb-0">Price Inquiries</h5>
                                <small class="text-warning">85% Accuracy</small>
                            </div>
                            <div class="col-auto">
                                <h4 class="mb-0">
                                    85%
                                    <span class="ms-2 align-top avtar avtar-xxs bg-light-warning">
                                        <i class="ti ti-minus text-warning"></i>
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item px-0">
                        <div class="row align-items-start">
                            <div class="col">
                                <h5 class="mb-0">Complex Queries</h5>
                                <small class="text-danger">78% Accuracy</small>
                            </div>
                            <div class="col-auto">
                                <h4 class="mb-0">
                                    78%
                                    <span class="ms-2 align-top avtar avtar-xxs bg-light-danger">
                                        <i class="ti ti-chevron-down text-danger"></i>
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="text-center">
                    <a href="#!" class="b-b-primary text-primary">
                        View Detailed Report
                        <i class="ti ti-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>
<!-- [ Main Content ] end -->
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/dashboard-default.js') }}"></script>
@endpush