@extends('admin.admin_master')
@section('title')
   PENDING 
@endsection
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Pending Actions</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#!">Pending Actions</a></li>
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
                                        style="float:right;" id="bulkApproveBtn">
                                        <i class="fas fa-check-double"></i> Bulk Pending Deployment
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
                                <table id="pending" class="table table-striped table-bordered nowrap">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Toggle all checkboxes
        document.getElementById('checkAllToggle').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.approve-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Bulk Approve button
        document.getElementById('bulkApproveBtn').addEventListener('click', function() {
            const checkedCheckboxes = document.querySelectorAll('.approve-checkbox:checked');
            const recordIds = Array.from(checkedCheckboxes).map(cb => cb.dataset.recordId);

            if (recordIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No personnel selected',
                    text: 'Please select at least one personnel to approve.'
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to approve these personnel?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('bulk-approve') }}',
                        data: { record_ids: recordIds },
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Approved!',
                                text: 'Personnel status has been updated successfully.',
                                timer: 1500,
                                showConfirmButton: false
                            });

                            setTimeout(() => {
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
            // Function to toggle all checkboxes
            function toggleAll() {
                var checkboxes = document.querySelectorAll('.approve-checkbox');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = !checkbox.checked;
                });
            }
            // Event listener for the Check All toggle
            document.getElementById('checkAllToggle').addEventListener('change', function() {
                toggleAll();
            });
            // Event listener for Bulk Approve button
            document.getElementById('bulkApproveBtn').addEventListener('click', function() {
                var checkedCheckboxes = document.querySelectorAll('.approve-checkbox:checked');
                var recordIds = Array.from(checkedCheckboxes).map(function(checkbox) {
                    return checkbox.dataset.recordId;
                });
                // Get CSRF token from the page
                var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
                // Make AJAX request to the server
                $.ajax({
                    type: 'POST',
                    url: '{{ route('bulk-approve') }}',
                    data: {
                        record_ids: recordIds,
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    success: function(data) {
                        // Handle success response from the server
                        console.log(data);
                        // Display a success message
                        alert('Status successfully updated');
                        // Redirect to the specified route after a short delay (e.g., 1 second)
                        setTimeout(function() {
                            window.location.href = '{{ route('record-manager') }}';
                        }, 1000);
                    },
                    error: function(error) {
                        // Handle error response from the server
                        console.error(error);
                    }
                });
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            var dataTable;
            dataTable = $('#pending').DataTable({
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
                    url: "{{ route('manager-pending-record') }}",
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
