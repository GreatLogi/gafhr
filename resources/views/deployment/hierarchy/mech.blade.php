@extends('admin.admin_master')
@section('admin')
    <style>
        .hierarchy-page {
            padding: 0;
        }

        .hierarchy-section {
            margin-bottom: 24px;
        }

        .hierarchy-panel {
            background: #fff;
            border: 1px solid #e6eaef;
            border-radius: 10px;
        }

        .hierarchy-panel .card-header {
            background: #fff;
            border-bottom: 1px solid #edf1f5;
        }

        .hierarchy-title {
            color: #1f2933;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .hierarchy-subtitle {
            color: #6b7280;
            font-size: 0.92rem;
            margin-bottom: 0;
        }

        .hierarchy-count {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border: 1px solid #d8dde3;
            border-radius: 999px;
            background: #fff;
            color: #4b5563;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .hierarchy-list {
            max-height: 260px;
            overflow: auto;
        }

        .hierarchy-list-item {
            padding: 12px 0;
            border-bottom: 1px solid #edf1f5;
        }

        .hierarchy-list-item:last-child {
            border-bottom: 0;
        }
    </style>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">HR Hierarchy Setup</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">Mechanizations</a></li>
                        <li class="breadcrumb-item"><a href="#">HR Hierarchy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-xl-3 mb-3">
                    <a href="{{ route('hierarchy.ghq.index') }}" class="btn btn-outline-primary w-100 py-4">GHQ Setup</a>
                </div>
                <div class="col-md-6 col-xl-3 mb-3">
                    <a href="{{ route('hierarchy.directorate.index') }}" class="btn btn-outline-primary w-100 py-4">Directorate Setup</a>
                </div>
                <div class="col-md-6 col-xl-3 mb-3">
                    <a href="{{ route('hierarchy.service-hq.index') }}" class="btn btn-outline-primary w-100 py-4">Service HQ Setup</a>
                </div>
                <div class="col-md-6 col-xl-3 mb-3">
                    <a href="{{ route('hierarchy.command-hq.index') }}" class="btn btn-outline-primary w-100 py-4">Command HQ Setup</a>
                </div>
            </div>
        </div>
    </div>
@endsection
