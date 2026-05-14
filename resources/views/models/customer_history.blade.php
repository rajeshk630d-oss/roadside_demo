<div class="modal-content" >
    <div class="modal-header">
        <h4 class="modal-title">Job History # {{$customer->name}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="card">
            <div class="card-header">
                <dl class="row">
                    @if($customer != NULL)
                        <dt class="col-sm-2" style="text-align: right">Customer Name :</dt>
                        <dd class="col-sm-4">{{$customer->name}}</dd>
                        <dt class="col-sm-2" style="text-align: right">Email :</dt>
                        <dd class="col-sm-4">{{$customer->email}}</dd>
                    @endif
                    @if($member != NULL)
                        <dt class="col-sm-2" style="text-align: right">Member Number :</dt>
                        <dd class="col-sm-4">{{$member->membership_no}}</dd>
                        <dt class="col-sm-2" style="text-align: right">Member Name :</dt>
                        <dd class="col-sm-4">{{$member->member_name}}</dd>
                        <dt class="col-sm-2" style="text-align: right">Vehicle No :</dt>
                        <dd class="col-sm-4">{{$member->vehicle_no}}</dd>
                        <dt class="col-sm-2" style="text-align: right">Expiry Date :</dt>
                        <dd class="col-sm-4">{{\Carbon\Carbon::parse($member->expiry_date)->format('d/m/Y')}}</dd>
                    @endif
                    @if($service != NULL)
                        <dt class="col-sm-2" style="text-align: right">Total Utilised :</dt>
                        <dd class="col-sm-4">{{$service->completed_services}}</dd>
                        <dt class="col-sm-2" style="text-align: right">Balance job Available :</dt>
                        <dd class="col-sm-4">{{$service->max_services - $service->completed_services}}</dd>
                    @endif
                </dl>
            </div>
            <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Job ID</th>
                            <th>Service</th>
                            <th>From Area</th>
                            <th>To Area</th>
                            <th>Vehicle No</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                            <tr>
                                <td>{{$job->id}}</td>
                                <td>{{$job->service->name}}</td>
                                <td>{{$job->from_service_area->name}}</td>
                                <td>{{$job->to_service_area->name}}</td>
                                <td>{{$job->vehicle_no}}</td>
                                <td>
                                    <?php
                                        if($job->status == 1)
                                            echo "Assigned";
                                        elseif($job->status == 2)
                                            echo "Completed";
                                        elseif($job->status == 3)
                                            echo "Cancelled";
                                        elseif($job->status == 4)
                                            echo "Not Done";
                                        else
                                            echo "Pending";
                                    ?>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
        </div>

    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>
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