<div class="modal fade" id="modal-not-done-job">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('not_done_job')}}" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Not done job # <span id="span_job_id"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="job_id" name="job_id" type="hidden">
                    <div class="form-group row">
                        <label for="not_done_reason" class="col-sm-3 col-form-label" style="text-align: right">
                            Reason :
                        </label>
                        <div class="col-sm-9">
                            <textarea name="not_done_reason" id="not_done_reason" class="form-control" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-cancel-job">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('cancel_job')}}" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Cancel job # <span id="span_cancell_job_id"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="cancell_job_id" name="job_id" type="hidden">
                    <div class="form-group row">
                        <label for="cancelled_reason" class="col-sm-3 col-form-label" style="text-align: right">
                            Reason :
                        </label>
                        <div class="col-sm-9">
                            <textarea name="cancelled_reason" id="cancelled_reason" class="form-control" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showNotDoneJobModel(id) {
        $("#span_job_id").text(id);
        $('#job_id').val(id);
        $('#modal-not-done-job').modal('show');
    }
    function showCancellJobModel(id) {
        $("#span_cancell_job_id").text(id);
        $('#cancell_job_id').val(id);
        $('#modal-cancel-job').modal('show');
    }
</script>