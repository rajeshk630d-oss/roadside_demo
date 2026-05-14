@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>User Logs</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">User Logs</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <form action="{{route('userLogs')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="form-group row">
                                        <label for="user_id" style="text-align: right" class="col-sm-1 col-form-label">
                                            User :
                                        </label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" style="width: 100%;" name="user_id" id="user_id"
                                                    data-placeholder="Search User" >
                                                <option value="" >-- Select User ---</option>
                                                @foreach($users as $user)
                                                    <?php
                                                    $select = "";
                                                    if($user->id == $user_id){
                                                        $select = "SELECTED";
                                                    }
                                                    ?>
                                                    <option value="{{$user->id}}" {{$select}}>{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label for="from_date" style="text-align: right" class="col-sm-1 col-form-label">From :</label>
                                        <div class="col-sm-2">
                                            <input type="date" class="form-control" name="from_date" id="from_date" value="{{$from_date}}" >
                                        </div>
                                        <label for="to_date" style="text-align: right" class="col-sm-1 col-form-label">To :</label>
                                        <div class="col-sm-2">
                                            <input type="date" class="form-control" name="to_date" id="to_date" value="{{$to_date}}">
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="submit" class="btn btn-info">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @if(count($logs) > 0)
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>User Name</th>
                                        <th>IP Address</th>
                                        <th>Operation</th>
                                        <th>Date and Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logs as $key => $log)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$log->user->name }}</td>
                                            <td>{{$log->ip_address }}</td>
                                            <td>{{$log->message }}</td>
                                            <td>{{ display_date_time($log->created_at, NULL , 'd/m/Y h:i A') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="{{asset('public/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('public/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        });
    </script>

    <script>
        $(function () {
            $('.select2').select2()
        })
    </script>
@endsection