<?php ini_set('memory_limit', '-1'); ?>
@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Members</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Members</li>
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
                                <form action="{{route('members.search')}}" method="post">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <?php
                                        $role_id = \Illuminate\Support\Facades\Auth::user()->role_id;
                                        $role = \App\Role::findOrFail($role_id);
                                        if($role->is_superadmin == 1){
                                        ?>

                                            <div class="col-2">
                                                <a href="{{url('import_members')}}" class="btn btn-primary">Import Members</a>
                                            </div>
                                            <div class="col-6">
                                                <input name="search_key" id="search_key" placeholder="Enter Search Key (Member Name or Mobile no or Membership No or Vehicle No or Chassis No)"
                                                       class="form-control" >
                                            </div>
                                            <div class="col-2">
                                                <button type="submit" class="btn btn-primary">Search Members</button>
                                            </div>
                                            @if(is_have_access(53))
                                            <div class="col-2">
                                                <a href="{{route('members.create')}}" class="btn btn-primary float-right">Add Member</a>
                                            </div>
                                            @endif
                                        <?php }else{ ?>
                                            <div class="col-4">
                                                <input name="search_key" id="search_key" placeholder="Enter Search Key"
                                                       class="form-control" >
                                            </div>
                                            <div class="col-3">
                                                <a href="{{url('')}}" class="btn btn-primary">Search Members</a>
                                            </div>
                                            @if(is_have_access(53))
                                            <div class="col-5">
                                                <a href="{{route('members.create')}}" class="btn btn-primary float-right">Add Member</a>
                                            </div>
                                            @endif
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                            @if(count($members) > 0)
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Membership Type</th>
                                        <th>Member Name</th>
                                        <th>Mobile Number</th>
                                        <th>Customer</th>
                                        <th>Membership No</th>
                                        <th>Vehicle No.</th>
                                        {{--<th>Chassis No.</th>--}}
                                        {{--<th>Engine No.</th>--}}
                                        {{--<th>MFG Year</th>--}}
                                        <th>Expiry Date</th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($members as $key => $member)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{isset($member->membership_type) ? $member->membership_type->name : ""}}</td>
                                            <td>{{$member->add_by_job == 0 ? $member->member_name : $member->member_name." - Added By Job"}}</td>
                                            <td>{{$member->mobile}}</td>
                                            <td>{{$member->customer->name}}</td>
                                            <td>{{$member->membership_no }}</td>
                                            <td>{{$member->vehicle_no }}</td>
                                            {{--<td>{{$member->chassis_no }}</td>--}}
                                            {{--<td>{{$member->engine_no }}</td>--}}
{{--                                            <td>{{$member->mfg_year }}</td>--}}
                                            <td>{{$member->expiry_date }}</td>
                                            <td class="project-actions text-right">
                                                <form action="{{ route('members.destroy', $member->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @if(is_have_access(54))
                                                    <a class="btn btn-info btn-sm" href="{{ route('members.edit', $member->id) }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    @endif
                                                    @if(is_have_access(55))
                                                    <button class="btn shadow-box btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure, you want to delete this Contractor?')">
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
                "responsive": true, "lengthChange": false, "autoWidth": false,"searching": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,

                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        });
    </script>
@endsection

