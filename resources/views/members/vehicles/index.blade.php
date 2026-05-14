@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Member Vehicles</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Member Vehicles</li>
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
                                <h3 class="card-title"></h3>
                                <a href="{{route('memberVehicles.create')}}" class="btn btn-primary float-right btn-sm">
                                    Add Vehicles
                                </a>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Membership Type</th>
                                        <th>Membership No.</th>
                                        <th>Vehicle Registration No.</th>
                                        <th>Chassis No.</th>
                                        <th>Engine No.</th>
                                        <th>V No.</th>
                                        <th>Vehicle Brand</th>
                                        <th>Vehicle Type</th>
                                        <th>Vehicle Registration Type</th>
                                        <th>Expiry Date</th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($vehicles as $key => $vehicle)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$vehicle->membership_type != NULL ? $vehicle->membership_type->name : "" }}</td>
                                            <td>{{$vehicle->membership_no }}</td>
                                            <td>{{$vehicle->vehicle_registration_no }}</td>
                                            <td>{{$vehicle->chassis_no }}</td>
                                            <td>{{$vehicle->engine_no }}</td>
                                            <td>{{$vehicle->v_no }}</td>
                                            <td>{{$vehicle->vehicle_brand != NULL ? $vehicle->vehicle_brand->name : "" }}</td>
                                            <td>{{$vehicle->vehicle_type != NULL ? $vehicle->vehicle_type->name : "" }}</td>

                                            <td>{{$vehicle->vehicle_registration_type != NULL ? $vehicle->vehicle_registration_type->name : "" }}</td>
                                            <td>{{$vehicle->registration_expiry_date }}</td>
                                            <td class="project-actions text-right">
                                                <form action="{{ route('memberVehicles.destroy', $vehicle->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a class="btn btn-info btn-sm" href="{{ route('memberVehicles.edit', $vehicle->id) }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <button class="btn shadow-box btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure, you want to delete this Vehicle?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
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
@endsection

