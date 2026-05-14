<?php
$nav_role = \App\Role::findOrFail(\Illuminate\Support\Facades\Auth::user()->role_id);
$nav_features = user_features();
$nav_is_admin = $nav_role->is_superadmin;
?>
    <div class="pad" style="padding-left: 20px">
        @if($nav_is_admin == 1 || in_array(2 , $nav_features)   )
        <a href="{{route('assigned_jobs')}}" class="btn btn-info">Assigned</a>
        @endif
        @if($nav_is_admin == 1 || in_array(6 , $nav_features)  )
            <a href="{{route('cancelled_jobs')}}" class="btn btn-danger">Cancelled</a>
        @endif
        @if($nav_is_admin == 1 || in_array(5 , $nav_features)  )
        <a href="{{route('not_done_jobs')}}" class="btn btn-danger">Not Done</a>
        @endif
        @if($nav_is_admin == 1 ||in_array(3 , $nav_features)  )
        <a href="{{route('completed_jobs')}}" class="btn btn-success">Completed</a>
        @endif
        @if($nav_is_admin == 1 || in_array(2 , $nav_features)  )
        <a href="{{route('pending_jobs')}}" class="btn btn-warning">Pending</a>
        @endif
        @if($nav_is_admin == 1 || in_array(7 , $nav_features)  )
        <a href="{{route('all_jobs')}}" class="btn btn-info">All</a>
        @endif
        @if($nav_is_admin == 1 || in_array(8 , $nav_features)  )
        <a href="{{route('job.create')}}" class="btn btn-success">Add New Job</a>
        @endif
    </div>