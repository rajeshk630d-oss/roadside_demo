<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
$errors = $errors->all();
$count = count($errors);
$msg = "";
if($count != 0){
    $msg = $errors[0];

?>
  <script>
      swal("","{{$msg}}",  "error");
  </script>
<?php
}
?>

@if(\Illuminate\Support\Facades\Session::has('flash_error'))
    <script>
        var alert_msg2 = '<?php echo \Illuminate\Support\Facades\Session::get('flash_error') ?>';
        swal("",alert_msg2,  "error");
    </script>
    <?php
    \Illuminate\Support\Facades\Session::forget('flash_error');
    ?>
@endif


@if(\Illuminate\Support\Facades\Session::has('flash_success'))
    <script>
        var alert_msg2 = '<?php echo \Illuminate\Support\Facades\Session::get('flash_success') ?>';
        swal("",alert_msg2,  "success");
    </script>
    <?php
    \Illuminate\Support\Facades\Session::forget('flash_success');
    ?>
@endif
