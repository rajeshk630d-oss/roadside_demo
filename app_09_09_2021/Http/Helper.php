<?php
function user_features(){
    $role_id  = \Illuminate\Support\Facades\Auth::user()->role_id;
    $role_features = \App\RoleFeature::where('RoleId' , $role_id)->get();
    $features = [];
    foreach($role_features as $feature){
        $features[] = $feature->FeatureId;
    }
    return $features;
}
function is_have_access($feature_id){
    $nav_role = \App\Role::findOrFail(\Illuminate\Support\Facades\Auth::user()->role_id);
    $nav_is_admin = $nav_role->is_superadmin;
    $role_id  = \Illuminate\Support\Facades\Auth::user()->role_id;
    $role_features = \App\RoleFeature::where('RoleId' , $role_id)->where('FeatureId' , $feature_id)->count();
    $feature = \App\Features::find($feature_id);
    if(($nav_is_admin || $role_features > 0) && $feature->hide_flag != 1){
        return true;
    }else{
        return false;
    }
}

if (! function_exists('areActiveRoutes')) {
    function areActiveRoutes(Array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
        return "";
    }
}
function areActiveMenu(Array $routes, $output = "nav-item menu-is-opening menu-open")
{
    foreach ($routes as $route) {
        if (Route::currentRouteName() == $route) return $output;
    }
    return "";
}
function is_admin($user_id){
    $user = \App\User::find($user_id);
    $role_id = $user->role_id;
    $role = \App\Role::find($role_id);
    if($role->is_superadmin == 1){
        return true;
    }else{
        return false;
    }
}
function get_company(){
    $company = \App\Companies::where('is_active' , 1)->first();
    return $company;
}
function generate_batch_no(){
    $last_id = \App\Job::max('batch_no');
    if( $last_id == NULL  || $last_id < 1000 ){
        $last_id = 1000;
    }else{
        $last_id++;
    }

    return str_pad($last_id , 4 , 0, STR_PAD_LEFT);
}
function generate_invoice_no(){
    return strtoupper(uniqid('INV'));
}
function display_date($date = NULL , $formate = null, $to_formate = null){
    $to_formate == NULL ? $to_formate = 'd/m/Y' : "";
    $formate == NULL ? $formate = 'Y-m-d' : "";
    if($date != NUll){
        return   \Carbon\Carbon::createFromFormat($formate,$date)->format($to_formate);
    }else{
        return \Carbon\Carbon::now()->format($to_formate);
    }
}
function display_date_time($date = NULL , $formate = null, $to_formate = null){
    $to_formate == NULL ? $to_formate = 'd/m/Y H:i:s' : "";
    $formate == NULL ? $formate = 'Y-m-d H:i:s' : "";
    if($date != NUll){
        return   \Carbon\Carbon::createFromFormat($formate,$date)->format($to_formate);
    }else{
        return \Carbon\Carbon::now()->format($formate);
    }
}

function validate_excel_date($value , $formate=""){
    $tempDate = explode('/', $value);
    if(count($tempDate) != 3 ){
        return false;
    }
    return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
    $d = DateTime::createFromFormat($value , $formate);
    return $d->format($formate) === $value;

}

function add_user_log($user_id , $key , $job_id = "", $message=""){
    $user_log = new \App\UserLog();
    $user_log->id = uniqid(rand());
    $user_log->user_id = $user_id;
    $user_log->operation_key = $key;
    $user_log->job_id = $job_id;
    if(strlen(trim($message)) == 0){
        $message = isset(config('view.log_keys')[$key]) ?  config('view.log_keys')[$key] : "";
    }
    $user_log->message = $message;
    $user_log->ip_address = \Request::ip();
    $user_log->save();
    return $user_log;
}
function rand_color() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}
function get_setting($key = NULL){
    if($key == NULL){
        return \App\AppSetting::get();
    }else{
        $line = \App\AppSetting::where('attribute' , $key)->first();
        if($line == NULL){
            return "";
        }else{
            return $line->attribute_value;
        }
    }
}
?>