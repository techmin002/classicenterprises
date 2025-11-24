@extends('setting::layouts.master')

@section('title', 'Company Profile')
@section('style')
    <link rel="stylesheet" href="https://unpkg.com/@yaireo/tagify/dist/tagify.css">
    <script src="https://unpkg.com/@yaireo/tagify"></script>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <div class="container py-4">
            <h3 class="mb-4 text-center fw-bold">Activity Logs</h3>

            <div class="row">
                @foreach ($logs as $log)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 h-100">
                            <div class="card-body">
                                <!-- User Info -->
                                <div class="d-flex align-items-center mb-2">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                        style="width:40px;height:40px;">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-bold">{{ $log->user->name ?? 'Unknown User' }}</h6>
                                        <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>

                                <!-- Action Performed -->
                                <p class="mb-2">
                                    <i class="bi bi-activity text-success me-1"></i>
                                    <strong>Action:</strong> {{ $log->perform }}
                                </p>

                                <!-- Branch -->
                                <p class="mb-2">
                                    <i class="bi bi-building text-primary me-1"></i>
                                    <strong>Branch:</strong> {{ $log->branch->name ?? 'N/A' }}
                                </p>

                                <!-- URL -->
                                <p class="mb-0">
                                    <i class="bi bi-link-45deg text-info me-1"></i>
                                    <strong>URL:</strong>
                                    <a href="{{ $log['url'] }}" class="text-decoration-none" target="_blank">
                                        {{ $log['url'] }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination (Optional) -->
            {{-- <div class="d-flex justify-content-center">
        {{ $logs->links() }}
    </div> --}}
        </div>
    </div>

@endsection
