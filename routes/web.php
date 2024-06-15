<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DistrictPercentageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Soe_masterController;
use App\Http\Controllers\ConstituencyController;
use App\Http\Controllers\SubSectorController;
use App\Http\Controllers\Scheme_masterController;
use App\Http\Controllers\FinyearController;
use App\Http\Controllers\Soe_budget_allocation_Controller;
use App\Http\Controllers\Soe_budget_distribution_Controller;
use App\Http\Controllers\Revenue_schemeController;
use App\Http\Controllers\CapitalSchemeController;
use App\Http\Controllers\CapitalRecordOnRevenueController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\MajorheadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinancialbudgetController;
use App\Http\Controllers\ReportsController;
//Guest routes
Route::group(['namespace' => 'App\Http\Controllers'], function()
{        
    Route::get('/', 'LoginController@show')->name('login.show');
    Route::post('/loginsubmit', 'LoginController@login')->name('login.perform');
});


//Auth Routes
Route::group(['middleware' => ['auth']], function() {

    
    Route::get('/chage_fin_year',[LoginController::class,'chage_fin_year'])->name('chage_fin_year');
    Route::get('/get_scheme_data',[DashboardController::class,'get_scheme_data'])->name('get_scheme_data');
    Route::get('/get_majorheads_data',[DashboardController::class,'get_majorheads_data'])->name('get_majorheads_data');
    Route::get('/get_chart_data',[DashboardController::class,'get_chart_data'])->name('get_chart_data');
    Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    // dashboard
    Route::get('/get_data_count',[DashboardController::class,'get_data_count'])->name('get_data_count'); // get all modules data count
    Route::get('/get_user_data_count',[DashboardController::class,'get_user_data_count'])->name('get_user_data_count'); // get all modules data count
    Route::get('/get_outlay_total', [DashboardController::class,'get_outlay_total'])->name('get_outlay_total'); // get outlay total
    Route::get('/get_plan_outlay_total', [DashboardController::class,'get_plan_outlay_total'])->name('get_plan_outlay_total'); // get plan based outlay total 
    Route::get('/get_district', [DashboardController::class,'get_district'])->name('get_district'); // get district list
    Route::get('/get_outlays', [DashboardController::class,'get_outlays'])->name('get_outlays'); // get hod, district outlays
    Route::get('/get_earmarked_outlays', [DashboardController::class,'get_earmarked_outlays'])->name('get_earmarked_outlays'); // get hod, district outlays
    Route::get('/get_district_budget_distributed', [DashboardController::class,'get_district_budget_distributed'])->name('get_district_budget_distributed'); // get district wise budget distribution

    //component route
    Route::view('create-component','component.create-component');
    Route::resource('component', ComponentController::class);
    Route::post('/component-import',[ComponentController::class,'import'])->name('component-import');

    //district route
    Route::view('create-district','district.create-district');
    Route::resource('district', DistrictController::class);
    Route::post('/district-import',[DistrictController::class,'import'])->name('district-import');

    //district percentage route
    Route::get('/create-percentage',[DistrictPercentageController::class,'districtList'])->name('create-percentage');
    Route::resource('district-percentage', DistrictPercentageController::class);

    //constituency route
    Route::resource('constituency', ConstituencyController::class);
    Route::get('/create-constituency',[ConstituencyController::class,'districtList'])->name('create-constituency');
    Route::post('/constituency-import',[ConstituencyController::class,'import'])->name('constituency-import');

    //user route
    Route::view('create-user','user.create-user');
    Route::resource('user', UserController::class);
    Route::view('/edit-user/{id?}','user.edit-user');
    Route::get('/get_user_data', [UserController::class,'get_user_data'])->name('get_user_data');

    //Plan route
    Route::view('create-plan','plan.create-plan');
    Route::resource('plan', PlanController::class);

    //service route
    Route::resource('service', ServiceController::class);
    Route::view('create-service','service.create-service');
    Route::post('/service-import',[ServiceController::class,'import'])->name('service-import');

    //sector route
    Route::view('create-sector','sector.create-sector');
    Route::get('/get_service_list', [SectorController::class,'get_service_list'])->name('get_service_list');
    Route::get('/get_sector_data', [SectorController::class,'get_sector_data'])->name('get_sector_data');
    Route::resource('sector', SectorController::class);
    Route::view('/edit-sector/{id?}','sector.edit-sector');
    Route::post('/sector-import',[SectorController::class,'import'])->name('sector-import');

    //sub-sector route
    Route::get('/create-sub-sector',[SubSectorController::class,'sectorList'])->name('create-sub-sector');
    Route::resource('sub-sector', SubSectorController::class);
    Route::view('/edit-sub-sector/{id?}','sub-sector.edit-sub-sector');
    Route::get('/get_subsector_data', [SubSectorController::class,'get_subsector_data'])->name('get_subsector_data');
    Route::post('/sub-sector-import',[SubSectorController::class,'import'])->name('sub-sector-import');
    Route::get('/get_sector', [SubSectorController::class,'get_sector'])->name('get_sector');

    //department route
    Route::resource('department', DepartmentController::class);
    Route::view('/create-department','department.create-department');
    Route::view('/edit-department/{id?}','department.edit-department');
    Route::get('/get_department_data', [DepartmentController::class,'get_department_data'])->name('get_department_data');
    Route::post('/department-import',[DepartmentController::class,'import'])->name('department-import');

    //majorhead route
    Route::resource('majorhead', MajorheadController::class);
    Route::get('/create-majorhead',[MajorheadController::class,'get_major_department'])->name('create_majorhead');
    Route::view('/edit-majorhead/{id?}','majorhead.edit-majorhead');
    Route::get('/get_majorhead_data', [MajorheadController::class,'get_majorhead_data'])->name('get_majorhead_data');
    Route::post('/majorhead-import',[MajorheadController::class,'import'])->name('majorhead-import');

    //scheme_master route
    Route::resource('scheme-master', Scheme_masterController::class);
    Route::view('/create-scheme-master','scheme-master.create-scheme-master');
    Route::get('/departmentList', [Scheme_masterController::class,'departmentList'])->name('departmentList');
    Route::get('/get_scheme_majorhead', [Scheme_masterController::class,'get_scheme_majorhead'])->name('get_scheme_majorhead');
    Route::view('/edit-scheme-master/{id?}','scheme-master.edit-scheme-master');
    Route::get('/get_schememaster_data', [Scheme_masterController::class,'get_schememaster_data'])->name('get_schememaster_data');
    Route::post('/scheme-master-import',[Scheme_masterController::class,'import'])->name('scheme-master-import');

    //soe_master route
    Route::resource('soe-master', Soe_masterController::class);
    Route::view('/create-soe-master','soe-master.create-soe-master');
    Route::get('/soe_department_list', [Soe_masterController::class,'soe_department_list'])->name('soe_department_list');
    Route::get('/get_soe_majorhead_by_department', [Soe_masterController::class,'get_soe_majorhead_by_department'])->name('get_soe_majorhead_by_department');
    Route::get('/get_soe_scheme_by_majorhead', [Soe_masterController::class,'get_soe_scheme_by_majorhead'])->name('get_soe_scheme_by_majorhead');
    Route::view('/edit-soe-master/{id?}','soe-master.edit-soe-master');
    Route::get('/get_soe_master_data', [Soe_masterController::class,'get_soe_master_data'])->name('get_soe_master_data');
    Route::post('/soe-master-import',[Soe_masterController::class,'import'])->name('soe-master-import');

    //finyear route
    Route::view('create-finyear','finyear.create-finyear');
    Route::resource('finyear', FinyearController::class);

    //soe budget allocation
    Route::resource('soe-budget-allocation', Soe_budget_allocation_Controller::class);
    Route::get('/create-soe-budget-allocation',[Soe_budget_allocation_Controller::class,'allList'])->name('create-soe-budget-allocation');
    Route::get('/get_allocation_majorhead_by_department', [Soe_budget_allocation_Controller::class,'get_allocation_majorhead_by_department'])->name('get_allocation_majorhead_by_department');
    Route::get('/get_allocation_scheme_by_majorhead', [Soe_budget_allocation_Controller::class,'get_allocation_scheme_by_majorhead'])->name('get_allocation_scheme_by_majorhead');
    Route::get('/get_allocation_soe_by_scheme', [Soe_budget_allocation_Controller::class,'get_allocation_soe_by_scheme'])->name('get_allocation_soe_by_scheme');
    Route::get('/get_allocation_sector_by_service', [Soe_budget_allocation_Controller::class,'get_allocation_sector_by_service'])->name('get_allocation_sector_by_service');
    Route::get('/get_allocation_subsector_by_sector', [Soe_budget_allocation_Controller::class,'get_allocation_subsector_by_sector'])->name('get_allocation_subsector_by_sector');
    Route::get('/get_soe_budget_allocation_data', [Soe_budget_allocation_Controller::class,'get_soe_budget_allocation_data'])->name('get_soe_budget_allocation_data');
    Route::view('/edit-soe-budget-allocation/{id?}','soe-budget-allocation.edit-soe-budget-allocation');
    Route::post('/soe-budget-allocation-import',[Soe_budget_allocation_Controller::class,'import'])->name('soe-budget-allocation-import');

    //soe budget distribution
    Route::resource('soe-budget-distribution', Soe_budget_distribution_Controller::class);

    Route::get('/soe-financial-budget-distribution/{id}',[Soe_budget_distribution_Controller::class,'soe_financial_budget_distribution'])->name('/soe_financial_budget_distribution');
    
    Route::get('/create-financial-budget',[FinancialbudgetController::class,'allList'])->name('create-financial-budget');


    Route::get('/create-soe-budget-distribution',[Soe_budget_distribution_Controller::class,'allList'])->name('create-soe-budget-distribution');
    Route::get('/get_distribution_majorhead_by_department', [Soe_budget_distribution_Controller::class,'get_distribution_majorhead_by_department'])->name('get_distribution_majorhead_by_department');
    Route::get('/get_distribution_scheme_by_majorhead', [Soe_budget_distribution_Controller::class,'get_distribution_scheme_by_majorhead'])->name('get_distribution_scheme_by_majorhead');
    Route::get('/get_distribution_soe_by_scheme', [Soe_budget_distribution_Controller::class,'get_distribution_soe_by_scheme'])->name('get_distribution_soe_by_scheme');
    Route::get('/get_soe_undistributed_outlay',[Soe_budget_distribution_Controller::class,'get_soe_undistributed_outlay'])->name('get_soe_undistributed_outlay');
    Route::get('/edit-soe-budget-distribution',[Soe_budget_distribution_Controller::class,'districtList'])->name('create-soe-budget-distribution');
    Route::get('/revised-soe-budget-distribution',[Soe_budget_distribution_Controller::class,'revised'])->name('revised-soe-budget-distribution');
    
    Route::get('/get_soe_budget_distribution_data', [Soe_budget_distribution_Controller::class,'get_soe_budget_distribution_data'])->name('get_soe_budget_distribution_data');
    Route::get('/get_districtPercentage', [Soe_budget_distribution_Controller::class,'get_districtPercentage'])->name('get_districtPercentage');
    Route::post('/soe-budget-distribution-import',[Soe_budget_distribution_Controller::class,'import'])->name('soe-budget-distribution-import');


    //revenue scheme
    Route::resource('revenue-scheme', Revenue_schemeController::class);

    //capital scheme
    Route::resource('capital-scheme', CapitalSchemeController::class);

    //Capital record on revenue
    Route::resource('capital-record-on-revenue', CapitalRecordOnRevenueController::class);
    Route::get('/create-capital-record-on-revenue',[CapitalRecordOnRevenueController::class,'all_capital_List'])->name('create-capital-record-on-revenue');
    Route::get('/addCapitalRecord/{id}',[CapitalRecordOnRevenueController::class,'addCapitalRecord'])->name('addCapitalRecord');
    Route::get('/viewCapitalRecord/{id}',[CapitalRecordOnRevenueController::class,'viewCapitalRecord'])->name('viewCapitalRecord');
    Route::get('/revenue-detail/{id}',[CapitalRecordOnRevenueController::class,'revenuedetail'])->name('revenuedetail');
    Route::get('/generate-pdf/{id}',[CapitalRecordOnRevenueController::class,'generatePDF'])->name('generatePDF');
    Route::post('/storerevenue/',[CapitalRecordOnRevenueController::class,'storerevenue'])->name('storerevenue');

    //logs
    Route::get('/get_log_of_revised_outlay/{id}', [Soe_budget_distribution_Controller::class,'get_log_of_revised_outlay'])->name('get_log_of_revised_outlay');
    Route::get('/edit-logs-soe-budget-distribution/{id}',[Soe_budget_distribution_Controller::class,'editlogs'])->name('edit.logs');
    Route::get('/show-edit-logs-soe-budget-distribution/{id}',[Soe_budget_distribution_Controller::class,'showeditlogs'])->name('show.edit.logs');

    //Reports
    Route::get('/show-department-wise-state-db',[ReportsController::class,'show_department_wise_state_db'])->name('show.department.wise.state.db');
    Route::get('/get-department-wise-state-db-data',[ReportsController::class,'get_department_wise_state_db_data'])->name('get.department.wise.state.db.data');
    Route::post('/export-department-wise-state-db',[ReportsController::class,'export_department_wise_state_db'])->name('export-department-wise-state-db');

    Route::get('/show-scheme-wise-state-db',[ReportsController::class,'scheme_wise_state_db'])->name('show.scheme.wise.state.db');
    Route::get('/get-scheme-wise-state-db-data',[ReportsController::class,'get_scheme_wise_state_db_data'])->name('get.scheme.wise.state.db.data');
    Route::post('/export-scheme-wise-state-db',[ReportsController::class,'export_scheme_wise_state_db'])->name('export.scheme.wise.state.db');

    Route::get('/show-department-wise-central-db',[ReportsController::class,'department_wise_central_db'])->name('show.department.wise.central.db');
    
    Route::get('/show-scheme-wise-central-db',[ReportsController::class,'scheme_wise_central_db'])->name('show.scheme.wise.central.db');

    Route::get('/show-department-wise-non-db',[ReportsController::class,'department_wise_non_db'])->name('show.department.wise.non.db');
    Route::get('/get-department-wise-non-db-data',[ReportsController::class,'get_department_wise_non_db_data'])->name('get.department.wise.non.db.data');
    Route::post('/export-department-wise-non-db',[ReportsController::class,'export_department_wise_non_db'])->name('export-department-wise-non-db');

    Route::get('/show-scheme-wise-non-db',[ReportsController::class,'scheme_wise_non_db'])->name('show.scheme.wise.non.db');
    Route::get('/get-scheme-wise-non-db-data',[ReportsController::class,'get_scheme_wise_non_db_data'])->name('get.scheme.wise.non.db.data');
    Route::post('/export-scheme-wise-non-db',[ReportsController::class,'export_scheme_wise_non_db'])->name('export-scheme-wise-non-db');

    Route::get('/get_allocation_soe', [ReportsController::class,'get_allocation_soe'])->name('get_allocation_soe');
    Route::get('/get_allocation_sector_by_department', [ReportsController::class,'get_allocation_sector_by_department'])->name('get_allocation_sector_by_department');

    //bluk import budget allocation
    Route::get('/show-bulk-import',[Soe_budget_allocation_Controller::class,'bulk_import_show'])->name('show.bulk.import');
    Route::post('/bulk-soe-budget-import',[Soe_budget_allocation_Controller::class,'bulkimport'])->name('bulk-soe-budget-import');


    Route::group(['namespace' => 'App\Http\Controllers'], function()
    {        
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});
