@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Companies</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Companies</li>
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
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>E-mail</th>
                                        <th>Telephone</th>
                                        <th>VAT No</th>
                                        <th>Cr No</th>
                                        <th>Logo</th>
                                        @if(is_have_access(57))
                                        <th>Options</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($companies as $key => $company)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$company->name }}</td>
                                            <td>{{$company->email }}</td>
                                            <td>{{$company->telephone }}</td>
                                            <td>{{$company->vat_no }}</td>
                                            <td>{{$company->cr_no }}</td>
                                            @if($company->image != NULL)
                                                <td>
                                                    <div class="widget-user-image" >
                                                        <img class="img-circle elevation-2"
                                                             style="width: 75px;height: 50px"
                                                             src="{{$company->image}}" />
                                                    </div>
                                                </td>
                                            @else
                                                <td>--</td>
                                            @endif
                                                @if(is_have_access(57))
                                                <td class="project-actions text-right">
                                                <a class="btn btn-info btn-sm" href="{{ route('aaaCompany.edit', $company->id) }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                </td>
                                                @endif
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

