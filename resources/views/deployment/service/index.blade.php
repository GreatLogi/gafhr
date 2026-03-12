@extends('admin.admin_master')
@section('admin')
    <style>
        #dataTable {
            font-size: 19px;
        }
    </style>
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Service</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">View</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row justify-content-center">
        <!-- liveline-section start -->
        <div class="col-sm-12">
            <div class="card user-profile-list">
                <div class="card-body">
                    <a href="{{ route('arm-add') }}" class="btn btn-primary btn-rounded waves-effect waves-light"
                        style="float:right;"><i class="fas fa-plus-circle"> Add Service </i></a> <br> <br>

                    <h4 class="card-title">ARM OF SERVICE</h4>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>SRL</th>
                                <th width="70%">ARM OF SERVICE</th>

                                <th width="20%">Action</th>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $key => $supplier)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> {{ $supplier->arm_of_service }} </td>

                                    <td>
                                        <a href="{{ route('arm-edit', $supplier->uuid) }}" class="btn btn-info sm"
                                            title="Edit Data"> <i class="fas fa-edit"></i> </a>

                                        <a href="{{ route('arm-delete', $supplier->uuid) }}" class="btn btn-danger sm"
                                            title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i> </a>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- liveline-section end -->
    </div>
    <!-- [ Main Content ] end -->
@endsection
