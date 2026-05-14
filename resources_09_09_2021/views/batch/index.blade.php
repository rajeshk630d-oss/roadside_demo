@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Batches</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Batches</li>
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
                                <h3 class="card-title">Batches</h3>
                                <a href="{{route('contractorInvoice')}}" class="btn btn-primary float-right btn-sm">Add Batch</a>
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
                                        <th>Batch No</th>
                                        <th>Contractor</th>
                                        <th>No. of Jobs</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        @if($is_admin)
                                        <th>Options</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($batches as $key => $batch)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$batch['batch_no'] }}</td>
                                            <td>{{$batch['contractor']->name }}</td>
                                            <td>{{$batch['job_count'] }}</td>
                                            <td>{{$batch['created_by']->name }}</td>
                                            <td>{{$batch['created_at'] }}</td>
                                            <td class="project-actions text-right">
                                                <form action="{{ route('batch.destroy', $batch['batch_no']) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @if($batch['can_edit'] == 1 && is_have_access(101))
                                                    <a class="btn btn-info btn-sm" href="{{ route('batch.edit', $batch['batch_no']) }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    @endif
                                                    @if($is_admin)
                                                    <button class="btn shadow-box btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure, you want to delete this batch?')">
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

