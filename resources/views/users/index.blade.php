@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
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
                                @if(is_have_access(86))
                                <a href="{{route('users.create')}}" class="btn btn-primary float-right btn-sm">Add User</a>
                                @endif
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Prevelige</th>
                                        <th>E-mail</th>
                                        <th>photo</th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $key => $user)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$user->name }}</td>
                                            <td>{{$user->role != NULL ? $user->role->name : ""}}</td>
                                            <td>{{$user->email }}</td>
                                            @if($user->image != NULL)
                                                <td>
                                                    <div class="widget-user-image" >
                                                        <img class="img-circle elevation-2"
                                                             style="width: 75px;height: 50px"
                                                             src="{{$user->image}}" />
                                                    </div>
                                                </td>
                                            @else
                                                <td>--</td>
                                            @endif
                                            <td class="project-actions text-right">
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @if(is_have_access(87))
                                                    <a class="btn btn-info btn-sm" href="{{ route('users.edit', $user->id) }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    @endif
                                                    @if(is_have_access(88))
                                                        <button class="btn shadow-box btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure, you want to delete this User?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endif
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

