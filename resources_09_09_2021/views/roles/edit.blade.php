@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Role</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Roles</a></li>
                            <li class="breadcrumb-item active">Update Role</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{route('roles.update' , $role->id)}}" method="post">
                {{csrf_field()}}

                <input type="hidden" name="_method" value="PATCH">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Role Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label" style="text-align: right">
                                        Name * :
                                    </label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="name" id="name"
                                               placeholder="Role Name" value="{{$role->name}}">
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="is_super_admin" name="is_super_admin"
                                            <?php if($role->is_superadmin == 1 ){ echo "checked";} ?>

                                            >
                                            <label for="is_super_admin">
                                                Is Super Admin
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card card-primary" id="feature_div">
                            <div class="card-header">
                                <h3 class="card-title">Role Privilegs</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label class="pr-2"> Select All </label>
                                        <input type="checkbox" id="checkall" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                @foreach($features as $feature)
                                    <div style="padding-left: 30px" class="col-md-12 col-xl-12">

                                        @if ( $feature->FeatureType == 0)
                                            @php
                                                $rolefeature = $role->id.'_'.$feature->FeatureId;
                                            @endphp
                                            <div class="row">
                                                <label style="text-transform: uppercase;"><strong>
                                                    <input class="qr-element" type="checkbox" name="FeatureId[]"
                                                           value="{{$role->id}}_{{$feature->FeatureId}}"
                                                           @if(is_array($role_features) && in_array($feature->FeatureId, $role_features)) checked @endif>
                                                        {{ $feature->FeatureName ." - ".$feature->FeatureId}} </strong>
                                                </label>
                                            </div>
                                        @endif
                                        <div class="row">
                                            @foreach($features as $submenurow)

                                                @if ($submenurow->FeatureType == 1 && $feature->FeatureId == $submenurow->Origin)

                                                    @php
                                                        $rolefeatureop = $role->id.'_'.$submenurow->FeatureId;
                                                    @endphp
                                                    <div class="col-sm-3 col-md-4">
                                                        <label class="pl-1">
                                                            <input class="qr-element" type="checkbox" name="FeatureId[]"
                                                                   value="{{$role->id}}_{{$submenurow->FeatureId}}"
                                                                   @if(is_array($role_features) && in_array($submenurow->FeatureId, $role_features)) checked @endif> {{ $submenurow->FeatureName }}</label>

                                                        @foreach($features as $subsubmenurow)
                                                            @if ($subsubmenurow->FeatureType == 2 && $submenurow->FeatureId == $subsubmenurow->Origin)
                                                                @php
                                                                    $subrolefeatureop = $role->id.'_'.$subsubmenurow->FeatureId;
                                                                @endphp

                                                                <br><label style="margin-left: 35px;">
                                                                    <input type="checkbox" class="qr-element" name="FeatureId[]" value="{{$role->id}}_{{$subsubmenurow->FeatureId}}" @if(is_array($role_features) && in_array($subrolefeatureop, $role_features)) checked @endif> {{ $subsubmenurow->FeatureName }}</label>
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('roles.index')}}" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Update Role" class="btn btn-success float-right">
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $('.select2').select2()
        })

    </script>
    <script type="text/javascript">
        $('#checkall').change(function () {
            $('.qr-element').prop('checked',this.checked);
        });
        if({{$role->is_superadmin}}){
            $('#feature_div').hide();
        }else{
            $('#feature_div').show();
        }
        $('#is_super_admin').change(function () {
            if(this.checked){
                $('#feature_div').hide();
            }else{
                $('#feature_div').show();
            }
        });

//        function change_feature_menu(){
//            alert(this.checked);
//        }

    </script>
@endsection