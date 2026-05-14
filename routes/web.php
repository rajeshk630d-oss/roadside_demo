<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/', 'Auth\LoginController@showLoginForm');
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'HomeController@profile')->name('profile');
    Route::post('/update_profile', 'HomeController@update_profile')->name('update_profile');

    Route::resource('vehicleBrand', 'Resource\VehicleBrandResource');
    Route::resource('vehicleType', 'Resource\VehicleTypeResource');
    Route::resource('registrationType', 'Resource\RegistrationTypeResource');

    Route::resource('serviceCountry', 'Resource\ServiceCountryResource');
    Route::resource('serviceArea', 'Resource\ServiceAreaResource');
    Route::resource('service', 'Resource\ServiceResource');

    Route::resource('contractors', 'Resource\ContractorsResource');
    Route::resource('contractorContracts', 'Resource\ContractorContractsResource');
    Route::resource('contractorVehicles', 'Resource\ContractorVehiclesResource');

    Route::resource('members', 'Resource\MembersResource');
    Route::get('import_members' , 'Resource\MembersResource@import_members');
    Route::post('save_import_members' , 'Resource\MembersResource@save_import_members');
    Route::any('search_members' , 'Resource\MembersResource@index')->name('members.search');
//    Route::resource('memberVehicles', 'Resource\MemberVehiclesResource');



    Route::resource('customers', 'Resource\CustomersResource');
    Route::resource('customerServices', 'Resource\CustomerServicesResource');
//    Route::resource('customerContracts', 'Resource\CustomerContractsResource');

    Route::resource('membershipTypes', 'Resource\MembershipTypesResource');
//    Route::resource('membershipServices', 'Resource\MembershipServicesResource');

    Route::resource('aaaCompany', 'Resource\AAACompanyResource');
    Route::resource('aaaPaymentType', 'Resource\AAAPaymentTypeResource');
    Route::resource('aaaSalesman', 'Resource\AAASalesmanResource');
    Route::resource('aaaDriver', 'Resource\AAADriverResource');
    Route::resource('aaaVehicle', 'Resource\AAAVehicleResource');
    Route::resource('roles', 'Resource\RoleResource');
    Route::resource('users', 'Resource\UserResource');
    Route::resource('job', 'Resource\JobResource');
    Route::resource('batch', 'Resource\BatchResource');

    Route::any('pending_jobs' , 'Resource\JobResource@index')->name('pending_jobs');
    Route::any('assigned_jobs' , 'Resource\JobResource@assgned_jobs')->name('assigned_jobs');
    Route::any('not_done_jobs' , 'Resource\JobResource@not_done_jobs')->name('not_done_jobs');
    Route::any('completed_jobs' , 'Resource\JobResource@completed_jobs')->name('completed_jobs');
    Route::any('cancelled_jobs' , 'Resource\JobResource@cancelled_jobs')->name('cancelled_jobs');
    Route::any('all_jobs' , 'Resource\JobResource@all_jobs')->name('all_jobs');
    Route::get('import_jobs' , 'Resource\JobResource@import_jobs')->name('import_jobs');
    Route::post('save_import_jobs' , 'Resource\JobResource@save_import_jobs');

    Route::get('assign_job/{id}', 'Resource\JobResource@assign')->name('job.assign');
    Route::post('assign_job/{id}', 'Resource\JobResource@assign_driver');

    Route::get('job_invoice/{id}', 'Resource\JobResource@get_job_invoice')->name('job_invoice');
    Route::get('print_job_invoice/{id}', 'Resource\JobResource@print_job_invoice')->name('print_job_invoice');
    Route::get('complete/{id}', 'Resource\JobResource@get_assigned_job')->name('job.complete');
    Route::post('complete_job/{id}', 'Resource\JobResource@complete_job');
    Route::post('not_done_job', 'Resource\JobResource@not_done_job')->name('not_done_job');
    Route::post('cancel_job', 'Resource\JobResource@cancel_job')->name('cancel_job');


    Route::get('get_driver/{id}','Resource\AAADriverResource@get_driver')->name('get_driver');
    Route::get('get_members','Resource\MembersResource@get_members')->name('get_members');
    Route::any('get_customer_history_popup','Resource\JobResource@get_customer_history_popup');
    Route::get('get_member_details/{id}','Resource\MembersResource@get_member_details')->name('get_member_details');

    Route::get('settings','HomeController@get_settings')->name('app_settings');
    Route::get('emailSettings','HomeController@get_email_settings')->name('email_settings');

    Route::any('userLogs' , 'HomeController@userLogs')->name('userLogs');

    Route::post('settings','HomeController@update_settings');
    Route::post('emailSettings','HomeController@update_email_settings');

    Route::any('contractorInvoice','HomeController@get_pending_invoices')->name('contractorInvoice');
    Route::post('saveContractorInvoice','HomeController@save_contractor_batch');

    Route::any('contractorPayment','HomeController@get_pending_batches')->name('contractorPayment');
    Route::post('saveContractorPayment','HomeController@save_contractor_payments');

    Route::any('contractorInquiry','HomeController@get_contractor_inquiry')->name('contractorInquiry');


    Route::get('getCustomerMembersDropdown/{id}', 'Resource\MembersResource@getCustomerMembersDropdown')->name('getCustomerMembersDropdown');

    Route::get('reports', 'ReportController@index')->name('reports');
    Route::get('getDailyReport', 'ReportController@getDailyReport')->name('getDailyReport');
    Route::post('getDailyReport', 'ReportController@viewDailyReport')->name('viewDailyReport');

    Route::get('getCustomerDailyReport', 'ReportController@getCustomerDailyReport')->name('getCustomerDailyReport');
    Route::post('ViewCustomerDailyReport', 'ReportController@ViewCustomerDailyReport')->name('ViewCustomerDailyReport');

    Route::get('getBatchReport', 'ReportController@getBatchReport')->name('getBatchReport');
    Route::post('viewBatchReport', 'ReportController@viewBatchReport')->name('viewBatchReport');

    Route::get('getContractorJobReport', 'ReportController@getContractorJobReport')->name('getContractorJobReport');
    Route::post('viewContractorJobReport', 'ReportController@viewContractorJobReport')->name('viewContractorJobReport');


    Route::get('getServiceAreaJobReport', 'ReportController@getServiceAreaJobReport')->name('getServiceAreaJobReport');
    Route::post('viewServiceAreaJobReport', 'ReportController@viewServiceAreaJobReport')->name('viewServiceAreaJobReport');

    Route::get('getAAAVehicleJobReport', 'ReportController@getAAAVehicleJobReport')->name('getAAAVehicleJobReport');
    Route::post('viewAAAVehicleJobReport', 'ReportController@viewAAAVehicleJobReport')->name('viewAAAVehicleJobReport');

    Route::get('getAAADriverJobReport', 'ReportController@getAAADriverJobReport')->name('getAAADriverJobReport');
    Route::post('viewAAADriverJobReport', 'ReportController@viewAAADriverJobReport')->name('viewAAADriverJobReport');

    Route::get('getServiceAreaSummeryJobReport', 'ReportController@getServiceAreaSummeryJobReport')->name('getServiceAreaSummeryJobReport');
    Route::post('ViewServiceAreaSummeryJobReport', 'ReportController@ViewServiceAreaSummeryJobReport')->name('ViewServiceAreaSummeryJobReport');

    Route::get('getCustomerServiceSummeryJobReport', 'ReportController@getCustomerServiceSummeryJobReport')->name('getCustomerServiceSummeryJobReport');
    Route::post('ViewCustomerServiceSummeryJobReport', 'ReportController@ViewCustomerServiceSummeryJobReport')->name('ViewCustomerServiceSummeryJobReport');

    //--------------------not completed------------------------
    Route::get('getCustomerMemberSummeryJobReport', 'ReportController@getCustomerMemberSummeryJobReport')
        ->name('getCustomerMemberSummeryJobReport');
    Route::post('ViewCustomerMemberSummeryJobReport', 'ReportController@ViewCustomerMemberSummeryJobReport')
        ->name('ViewCustomerMemberSummeryJobReport');

    Route::get('getAreaSummeryChart', 'ReportController@getAreaSummeryChart')->name('getAreaSummeryChart');
    Route::post('ViewAreaSummeryChart', 'ReportController@ViewAreaSummeryChart')->name('ViewAreaSummeryChart');

    Route::get('getAAAVehicleChart', 'ReportController@getAAAVehicleChart')->name('getAAAVehicleChart');
    Route::post('viewAAAVehicleChart', 'ReportController@viewAAAVehicleChart')->name('viewAAAVehicleChart');

    Route::get('getMembersReport', 'ReportController@getMembersReport')->name('getMembersReport');
    Route::post('viewMembersReport', 'ReportController@viewMembersReport')->name('viewMembersReport');

    Route::get('getCustomerMemberJobsReport', 'ReportController@getCustomerMemberJobsReport')->name('getCustomerMemberJobsReport');
    Route::post('viewCustomerMemberJobsReport', 'ReportController@viewCustomerMemberJobsReport')->name('viewCustomerMemberJobsReport');

    Route::get('getAAAServiceSummeryChart', 'ReportController@getAAAServiceSummeryChart')->name('getAAAServiceSummeryChart');
    Route::post('viewAAAServiceSummeryChart', 'ReportController@viewAAAServiceSummeryChart')->name('viewAAAServiceSummeryChart');

    Route::get('getContractorAreaSummeryReport', 'ReportController@getContractorAreaSummeryReport')->name('getContractorAreaSummeryReport');
    Route::post('ViewContractorAreaSummeryReport', 'ReportController@ViewContractorAreaSummeryReport')->name('ViewContractorAreaSummeryReport');

    Route::get('getMemberVehicleWiseReport', 'ReportController@getMemberVehicleWiseReport')->name('getMemberVehicleWiseReport');
    Route::post('ViewMemberVehicleWiseReport', 'ReportController@ViewMemberVehicleWiseReport')->name('ViewMemberVehicleWiseReport');

    Route::get('getDriverWiseJobsReport', 'ReportController@getDriverWiseJobsReport')->name('getDriverWiseJobsReport');
    Route::post('ViewDriverWiseJobsReport', 'ReportController@ViewDriverWiseJobsReport')->name('ViewDriverWiseJobsReport');

    Route::get('getCustomerListReport', 'ReportController@getCustomerListReport')->name('getCustomerListReport');
    Route::get('backup', 'BackupController@index')->name('backup');
    Route::get('getBackup', 'BackupController@get_backup')->name('getBackup');
    Route::get('downloadBackup/{id}', 'BackupController@download_backup')->name('downloadBackup');


    Route::get('getCustomerCostAnalysisReport', 'ReportController@getCustomerCostAnalysisReport')->name('getCustomerCostAnalysisReport');
    Route::post('ViewCustomerCostAnalysisReport', 'ReportController@ViewCustomerCostAnalysisReport')->name('ViewCustomerCostAnalysisReport');

    Route::get('getSubContractorsReport', 'ReportController@getSubContractorsReport')->name('getSubContractorsReport');
    Route::post('ViewSubContractorsReport', 'ReportController@ViewSubContractorsReport')->name('ViewSubContractorsReport');
    
    
    Route::get('getSubContractorsBatchReport', 'ReportController@getSubContractorsBatchReport')->name('getSubContractorsBatchReport');
    Route::post('ViewSubContractorsBatchReport', 'ReportController@ViewSubContractorsBatchReport')->name('ViewSubContractorsBatchReport');


//     Route::get('get_jobs_list', 'ReportController@get_jobs_list')->name('get_jobs_list');
//     // Route::post('view_get_jobs_list', 'ReportController@view_get_jobs_list')->name('view_get_jobs_list');

// Route::match(['get', 'post'], '/view_get_jobs_list', [ReportController::class, 'view_get_jobs_list'])
//     ->name('view_get_jobs_list');
// // Route::match(['get', 'post'], '/view_get_jobs_list', [ReportController::class, 'view_get_jobs_list']);


Route::get('/get_jobs_list', [ReportController::class, 'get_jobs_list'])->name('get_jobs_list');
Route::post('/view_get_jobs_list', [ReportController::class, 'view_get_jobs_list'])->name('view_get_jobs_list');

});


