@extends('admin.admin_master')
@section('title')
  APPROVED  
@endsection
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Approve</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#!">Approve</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-pattern">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card user-profile-list">
                    <div class="card-header">
                        <nav class="p-0 navbar justify-content-between align-items-center">
                            <h5>Details of Pending Actions</h5>
                            <div class="text-right col-sm-6"><br />
                                <div class="mb-2 mr-2 btn-group" style="display: inline-block;">
                                    <a href="{{ route('record-manager') }}"
                                        class="btn btn-primary btn-rounded waves-effect waves-light" style="float:right;">
                                        <i class="fas fa-backward"> </i> Go Back</a>
                                </div>
                                <div class="mb-2 mr-2 btn-group" style="display: inline-block;">
                                    <a href="#" class="btn btn-success btn-rounded waves-effect waves-light"
                                        style="float:right;" id="bulkDeploymentBtn">
                                        <i class="fas fa-check-double"></i> Bulk Approval
                                    </a>
                                </div>
                                <div class="text-right" style="float: right;">
                                    <div class="form-check form-switch"
                                        style="display: inline-flex; padding: 0.75em 2em; color: #fff; background-color:rgb(151, 195, 75)">
                                        <input class="form-check-input" type="checkbox" id="checkAllToggle">
                                        <label class="form-check-label" for="checkAllToggle">Check All</label>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center m-l-0">
                            <div class="dt-responsive table-responsive">
                                <table id="approve" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>
                                                No.
                                            </th>
                                            <th>#SVC ID</th>
                                            <th>RANK</th>
                                            <th>PERSONNEL</th>
                                            <th>GENDER</th>
                                            <th>PURPOSE</th>
                                            <th>COUNTRY</th>
                                            <th>DEPARTURE DATE</th>
                                            <th>DAYS LEFT FOR DEPARTURE</th>
                                            <th></th>
                                            <th>STATUS</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function toggleAll() {
            var checkboxes = document.querySelectorAll('.approve-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = !checkbox.checked;
            });
        }

        document.getElementById('checkAllToggle').addEventListener('change', function() {
            toggleAll();
        });

        document.getElementById('bulkDeploymentBtn').addEventListener('click', function() {
            var checkedCheckboxes = document.querySelectorAll('.approve-checkbox:checked');
            var recordIds = Array.from(checkedCheckboxes).map(function(checkbox) {
                return checkbox.dataset.recordId;
            });

            if (recordIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No personnel selected',
                    text: 'Please select at least one personnel for deployment.'
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to deploy the selected personnel?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, deploy them'
            }).then((result) => {
                if (result.isConfirmed) {
                    var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('bulk-deployment') }}',
                        data: {
                            record_ids: recordIds,
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deployed!',
                                text: 'Personnel deployment status updated successfully.',
                                timer: 1500,
                                showConfirmButton: false
                            });

                            setTimeout(function() {
                                window.location.href = '{{ route('record-manager') }}';
                            }, 1500);
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong! Please try again.'
                            });
                            console.error(error);
                        }
                    });
                }
            });
        });
    });
</script>

    
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            function toggleAll() {
                var checkboxes = document.querySelectorAll('.approve-checkbox');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = !checkbox.checked;
                });
            }
            document.getElementById('checkAllToggle').addEventListener('change', function() {
                toggleAll();
            });
            document.getElementById('bulkDeploymentBtn').addEventListener('click', function() {
                var checkedCheckboxes = document.querySelectorAll('.approve-checkbox:checked');
                var recordIds = Array.from(checkedCheckboxes).map(function(checkbox) {
                    return checkbox.dataset.recordId;
                });
                var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
                $.ajax({
                    type: 'POST',
                    url: '{{ route('bulk-deployment') }}',
                    data: {
                        record_ids: recordIds,
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    success: function(data) {
                        console.log(data);
                        alert('Status successfully updated');
                        setTimeout(function() {
                            window.location.href = '{{ route('record-manager') }}';
                        }, 1000);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            var dataTable;
            dataTable = $('#approve').DataTable({
                dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                buttons: [
                    'colvis',
                    {
                        extend: 'copy',
                        text: 'Copy to clipboard'
                    },
                    'excel',
                ],
                scrollY: 960,
                scrollCollapse: true,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [15, 25, 50, 100, 200, -1],
                    [15, 25, 50, 100, 200, 'All'],
                ],
                ajax: {
                    url: "{{ route('manager-approve-record') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'svcnumber',
                        name: 'svcnumber'
                    },
                    {
                        data: 'rank_name',
                        name: 'rank_name'
                    },
                    {
                        data: 'initial',
                        name: 'initial'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'purpose',
                        name: 'purpose'
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'departure_date',
                        name: 'departure_date'
                    },
                    {
                        data: 'departuredays',
                        name: 'departuredays'
                    },
                    {
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                ],
            });
        });
    </script>

    
@endsection
