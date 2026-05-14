@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Backups</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Data Backups</li>
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
                                <h3 class="card-title">Data Backups</h3>
                                <a href="{{route('getBackup')}}" onclick="disableButton()"
                                   class="btn btn-primary float-right btn-sm">Create Backup</a>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <?php
                                    $is_admin = is_admin(\Illuminate\Support\Facades\Auth::user()->id);
                                    ?>
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>User</th>
                                        <th>Folder</th>
                                        <th>Created at</th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($backups as $key => $backup)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{ $backup->user->name }}</td>
                                            <td>{{$backup->backup_folder }}</td>
                                            <td>{{display_date_time($backup->created_at) }}</td>
                                            <td class="project-actions text-right">
                                                <a class="btn btn-info btn-sm" href="{{ route('downloadBackup', $backup->id) }}">
                                                    <i class="fas fa-download"> Download</i>
                                                </a>
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
        function disableButton() {
//            alert("hi");
            var btn = document.getElementById('CreateBackup');
//            getElementById('CreateBackup').style.display = 'block';
            btn.innerText = 'Creating Backup......'
        }
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection

