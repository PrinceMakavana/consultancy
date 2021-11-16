<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     // 2020_04_03_030119_
//     for ($i = 18; $i < 21; $i++) {
//         $users = DB::table('migrations')->select('migration')->where('id', $i)->get();
//         $migration = str_replace('2020_03_29_081344_', '2020_04_03_030122_', $users[0]->migration);
//         DB::table('migrations')
//             ->where('id', $i)
//             ->update(['migration' => $migration]);
//     }
// });



Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('reset-successfully', 'HomeController@resetSuccessfully');

Auth::routes([
    'register' => false, // Registration Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/', function () {
    return redirect()->route('home');
});

Route::middleware(['web', 'auth', 'role:superadmin'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard/insurance', 'HomeController@insurance')->name('dashboard-insurance');

    Route::get('/change-password', 'HomeController@changePassword')->name('change-password');
    Route::post('/submit-change-password', 'HomeController@submitChangePassword')->name('submit-change-password');
    Route::get('/submit-change-password', function () { return redirect()->route('change-password'); })->name('submit-change-password');
    
    Route::put('/client/fund/user-plan/{id}/mutual-fund', 'ClientController@updateUserPlanIdMutualFund')->name('client.update-plan-id.mutual-fund');
    Route::put('/client/fund/user-plan/{id}/traditional-insurance', 'ClientController@updateUserPlanIdTraditionalInsurance')->name('client.update-plan-id.traditional-insurance');
    Route::put('/client/fund/user-plan/{id}/ulip-insurance', 'ClientController@updateUserPlanIdUlipInsurance')->name('client.update-plan-id.ulip-insurance');
    
    Route::get('/client/anydata', 'ClientController@anyData')->name('client.data');
    Route::get('/client/muFund/{id}', 'ClientController@muFund')->name('client.muFund');
    Route::get('/client/insurance-policies/{id}', 'ClientController@insurancePolicies')->name('client.insurance-polices');
    Route::get('/client/fund/{id}', 'ClientController@goalPlan')->name('client.goalPlan');
    Route::get('/client/fund/{id}/insurance', 'ClientController@goalPlanInsurance')->name('client.goalPlanInsurance');
    Route::get('/client/get-all-clients', 'ClientController@getAllClients')->name('client.getAll');
    Route::get('/client/change-password/{id}', 'ClientController@changePassword')->name('client.change-password');
    Route::post('/client/save-password/{id}', 'ClientController@savePassword')->name('client.save-password');
    Route::get('client/view/{id}', 'ClientController@show')->name('client.view');
    Route::get('/client/{client_id}/person-anydata', 'PersonController@anyData')->name('person.data');
    Route::get('/client/{id}/person-detail/{person_id}', 'ClientController@show')->name('client.person-detail');
    Route::get('/client/{id}/person-detail/{person_id}/user-document', 'ClientController@userDocument')->name('client.person-detail.user-document');
    Route::resource('/client/{client_id}/person', 'PersonController');
    Route::resource('/client', 'ClientController');
    Route::post('greetings/send-test-greeting', 'GreetingController@sendTestNotification')->name('greetings.send-test-greeting');
    Route::get('greetings/test-greeting', 'GreetingController@testNotification')->name('greetings.test-greeting');
    Route::get('greetings/anydata', 'GreetingController@anyData')->name('greetings.data');
    Route::get('greetings/calendar', 'GreetingController@calendar')->name('greetings.calendar');
    Route::post('greetings/calendar/events-sip', 'GreetingController@calendarEventsSip')->name('greetings.calendar-events-sip');
    Route::get('greetings/calendar/events-sip', 'GreetingController@calendarEventsSip')->name('greetings.calendar-events-sip');
    Route::post('greetings/calendar/events-insurance', 'GreetingController@calendarEventsInsurance')->name('greetings.calendar-events-insurance');
    Route::get('greetings/calendar/events-insurance', 'GreetingController@calendarEventsInsurance')->name('greetings.calendar-events-insurance');
    
    Route::resource('/greetings', 'GreetingController');
    
    
    Route::prefix('mutual-fund-investment')->group(function () {
        Route::get('user-sip/{id}/instalment-anydata', 'UserSipController@instalmentAnyData')->name('user-sip.instalment.index');
        Route::delete('user-sip/{sip_id}/delete-instalment/{id}', 'UserSipController@instalmentDestroy')->name('user-sip.instalment.destroy');
        Route::get('user-sip/{id}/add-instalment', 'UserSipController@addInstalment')->name('user-sip.add-instalment');
        Route::post('user-sip/{id}/add-instalment?opt=varify', 'UserSipController@storeInstalment')->name('user-sip.varify-instalment');
        Route::post('user-sip/{id}/add-instalment', 'UserSipController@storeInstalment')->name('user-sip.store-instalment');
        Route::get('user-sip/anydata', 'UserSipController@anyData')->name('user-sip.data');
        // Route::get('user-sip/get-options/{field}', 'UserSipController@getOptions');
        
        Route::get('user-mutual-fund/anydata', 'UserMutualFundController@anyData')->name('user-mutual-fund.data');
        Route::get('user-mutual-fund/myFundHistory/{id}', 'UserMutualFundController@myFundHistory')->name('user.myFundHistory');
        
        Route::get('user-lump-sum/anydata', 'UserLumpSumController@anyData')->name('user-lump-sum.data');
        Route::post('user-lump-sum?opt=varify', 'UserLumpSumController@store')->name('user-lump-sum.varify-investment');
        
        Route::resource('user-sip', 'UserSipController');
        Route::resource('user-mutual-fund', 'UserMutualFundController');
        Route::resource('user-mutual-fund/{user_fund_id}/withdraw', 'WithdrawController');
        Route::resource('user-lump-sum', 'UserLumpSumController');
    });
    
    Route::prefix('mutual-fund')->group(function () {
        Route::get('type/anydata', 'MutualFundTypeController@anyData')->name('type.data');
        Route::get('company/anydata', 'MutualFundCompaniesController@anyData')->name('company.data');
        Route::get('funds/anydata', 'MutualFundController@anyData')->name('funds.data');
        Route::get('funds/{id}/nav', 'MutualFundController@nav')->name('funds.nav');
        Route::put('funds/{id}/nav/update', 'MutualFundController@nav_update')->name('funds.nav_update');
        
        Route::resource('type', 'MutualFundTypeController');
        Route::resource('company', 'MutualFundCompaniesController');
        Route::resource('funds', 'MutualFundController');
    });
    Route::prefix('insurance')->group(function () {
        Route::get('category/anydata', 'InsuranceCategoryController@anyData')->name('category.data');
        Route::get('field/anydata', 'InsuranceFieldController@anyData')->name('field.data');
        Route::get('field/view/{id}', 'InsuranceFieldController@show')->name('field.view');
        Route::get('field-detail/anydata', 'InsuranceFieldDetailsController@anyData')->name('field-detail.data');
        Route::get('field-detail/fielddata', 'InsuranceFieldDetailsController@fieldData')->name('field-detail.fielddata');
        // Route::get('sub-category/anydata', 'InsuranceSubCategoryController@anyData')->name('sub-category.data');
        Route::get('insurance-company/anydata', 'InsuranceCompanyController@anyData')->name('insurance-company.data');
        Route::get('policy/anydata', 'PolicyMasterController@anyData')->name('policy.data');
        Route::get('policy/statement/{id}', 'PolicyMasterController@statement')->name('policy.statement');
        Route::get('policy/add-details/{id}', 'PolicyMasterController@addOtherDetails')->name('policy.add-details');
        Route::post('policy/store-details/{id}', 'PolicyMasterController@storeOtherDetails')->name('policy.store-details');
        Route::get('policy/premium-mode/{policy_id}/edit', 'PolicyMasterController@premium_mode_edit')->name('policy.premium-mode.edit');
        Route::post('policy/premium-mode/{policy_id}/update', 'PolicyMasterController@premium_mode_update')->name('policy.premium-mode.update');
        Route::get('policy/change-status/{policy_id}/{status}', 'PolicyMasterController@changeStatus')->name('policy.change-status');
        
        Route::resource('policy', 'PolicyMasterController');
        Route::resource('category', 'InsuranceCategoryController');
        Route::resource('field', 'InsuranceFieldController');
        Route::resource('field.field-detail', 'InsuranceFieldDetailsController');
        // Route::resource('sub-category', 'InsuranceSubCategoryController');
        Route::resource('insurance-company', 'InsuranceCompanyController');
        
        Route::get('life-insurance-traditional/anydata', 'LifeInsuranceTraditionalController@anyData')->name('life-insurance-traditional.data');
        Route::get('life-insurance-traditional/statement/{id}', 'LifeInsuranceTraditionalController@statement2')->name('life-insurance-traditional.statement');
        
        Route::get('life-insurance-traditional/{policy_id}/{tbl_key}/premium/anydata', 'PremiumMasterController@anyData')->name('premium.data');
        Route::get('life-insurance-ulip/{policy_id}/{tbl_key}/premium/anydata', 'PremiumMasterController@anyData')->name('premium.ulip.data');
        Route::get('life-insurance-traditional/{policy_id}/{tbl_key}/benefits/anydata', 'PolicyBenefitsController@anyData')->name('benefits.data');
        Route::get('life-insurance-ulip/{policy_id}/{tbl_key}/benefits/anydata', 'PolicyBenefitsController@anyData')->name('benefits.ulip.data');
        // Route::get('life-insurance-traditional/{policy_id}/{tbl_key}/{benefit_type}/benefits/create', 'PolicyBenefitsController@create')->name('benefits.create');
        // Route::get('life-insurance-ulip/{policy_id}/{tbl_key}/{benefit_type}/benefits/create', 'PolicyBenefitsController@create')->name('benefits.ulip.create');
        // Route::get('life-insurance-traditional/{policy_id}/{tbl_key}/premium/create', 'PremiumMasterController@create')->name('premium.traditional.create');
        // Route::get('life-insurance-ulip/{policy_id}/{tbl_key}/premium/create', 'PremiumMasterController@create')->name('premium.ulip.create');
        
        Route::get('life-insurance-ulip/anydata', 'LifeInsuranceUlipController@anyData')->name('life-insurance-ulip.data');
        Route::get('life-insurance-ulip/statement/{id}', 'LifeInsuranceUlipController@statement2')->name('life-insurance-ulip.statement');
        
        Route::resource('life-insurance-traditional/{policy_id}/benefits', 'PolicyBenefitsController', ['names' => 'life-insurance-traditional.benefits']);
        Route::resource('life-insurance-ulip/{policy_id}/benefits', 'PolicyBenefitsController', ['names' => 'life-insurance-ulip.benefits']);
        
        Route::group(['prefix' => 'life-insurance-traditional', 'as' => 'life-insurance-traditional.'], function () {
            Route::get('{policy_id}/change-status/{status}', 'LifeInsuranceTraditionalController@changeStatus')->name('change-status');
        });
        Route::group(['prefix' => 'life-insurance-ulip', 'as' => 'life-insurance-ulip.'], function () {
            Route::get('{policy_id}/change-status/{status}', 'LifeInsuranceUlipController@changeStatus')->name('change-status');
            Route::resource('actual-value-request', 'UlipActualValueRequestController', ['only' => ['index', 'edit', 'update', 'destroy']]);
            
            Route::get('actual-value-request/anydata', 'UlipActualValueRequestController@anyData')->name('actual-value-request.data');
        });
        
        Route::get('life-insurance-traditional/{policy_id}/assured-payouts/create', 'LifeInsuranceTraditionalController@assured_payouts')->name('life-traditional.assured-payouts.create');
        Route::post('life-insurance-traditional/{policy_id}/assured-payouts/store', 'LifeInsuranceTraditionalController@assured_payouts_store')->name('life-traditional.assured-payouts.store');
        Route::get('life-insurance-traditional/{policy_id}/premium-mode/edit', 'LifeInsuranceTraditionalController@premium_mode_edit')->name('life-traditional.premium-mode.edit');
        Route::post('life-insurance-traditional/{policy_id}/premium-mode/update', 'LifeInsuranceTraditionalController@premium_mode_update')->name('life-traditional.premium-mode.update');
        Route::get('life-insurance-ulip/{policy_id}/premium-mode/edit', 'LifeInsuranceUlipController@premium_mode_edit')->name('life-ulip.premium-mode.edit');
        Route::post('life-insurance-ulip/{policy_id}/premium-mode/update', 'LifeInsuranceUlipController@premium_mode_update')->name('life-ulip.premium-mode.update');
        Route::resource('policy/{policy_id}//premium', 'PremiumMasterController');
        
        Route::resource('life-insurance-ulip/insurance-benefits/{policy_id}/{tbl_key}/benefit', 'PolicyBenefitsController', ['names' => 'insurance-benefits-ulip']);
        Route::resource('life-insurance-ulip/insurance-premiums/{policy_id}/{tbl_key}/premium', 'PremiumMasterController', ['names' => 'insurance-premiums-ulip']);
        Route::resource('life-insurance-ulip/insurance-documents/{policy_id}/{tbl_key}/document', 'PolicyDocumentsController', ['names' => 'insurance-documents-ulip']);
        Route::get('life-insurance-ulip/insurance-terminate/{policy_id}/{tbl_key}/terminate', 'TerminatePolicyController@terminate')->name('insurance-terminate-ulip.form');
        Route::post('life-insurance-ulip/insurance-terminate/{policy_id}/{tbl_key}/terminate', 'TerminatePolicyController@terminateSave')->name('insurance-terminate-ulip.save');
        Route::get('life-insurance-ulip/insurance-surrender/{policy_id}/{tbl_key}/surrender', 'SurrenderPolicyController@surrender')->name('insurance-surrender-ulip.form');
        Route::post('life-insurance-ulip/insurance-surrender/{policy_id}/{tbl_key}/surrender', 'SurrenderPolicyController@surrenderSave')->name('insurance-surrender-ulip.save');
        Route::get('life-insurance-ulip/insurance-withdraw/{policy_id}/{tbl_key}/withdraw-units', 'LifeInsuranceUlipController@withdrawUnits')->name('insurance-withdraw-ulip.form');
        Route::post('life-insurance-ulip/insurance-withdraw/{policy_id}/{tbl_key}/withdraw-units', 'LifeInsuranceUlipController@withdrawUnitsSave')->name('insurance-withdraw-ulip.save');
        Route::delete('life-insurance-ulip/insurance-withdraw/{policy_id}/{tbl_key}/withdraw-units/{id}', 'LifeInsuranceUlipController@withdrawUnitsDestroy')->name('insurance-withdraw-ulip.destroy');
        Route::get('life-insurance-ulip/insurance-nav/{policy_id}/{tbl_key}/nav-update', 'LifeInsuranceUlipController@editNav')->name('insurance-nav-update-ulip.form');
        Route::post('life-insurance-ulip/insurance-nav/{policy_id}/{tbl_key}/nav-update', 'LifeInsuranceUlipController@updateNav')->name('insurance-nav-update-ulip.save');
        
        Route::resource('life-insurance-traditional/insurance-benefits/{policy_id}/{tbl_key}/benefit', 'PolicyBenefitsController', ['names' => 'insurance-benefits-traditional']);
        Route::resource('life-insurance-traditional/insurance-premiums/{policy_id}/{tbl_key}/premium', 'PremiumMasterController', ['names' => 'insurance-premiums-traditional']);
        Route::resource('life-insurance-traditional/insurance-documents/{policy_id}/{tbl_key}/document', 'PolicyDocumentsController', ['names' => 'insurance-documents-traditional']);
        Route::get('life-insurance-traditional/insurance-terminate/{policy_id}/{tbl_key}/terminate', 'TerminatePolicyController@terminate')->name('insurance-terminate-traditional.form');
        Route::post('life-insurance-traditional/insurance-terminate/{policy_id}/{tbl_key}/terminate', 'TerminatePolicyController@terminateSave')->name('insurance-terminate-traditional.save');
        
        Route::resource('policy/insurance-benefits/{policy_id}/{tbl_key}/benefit', 'PolicyBenefitsController', ['names' => 'insurance-benefits-general']);
        Route::resource('policy/insurance-premiums/{policy_id}/{tbl_key}/premium', 'PremiumMasterController', ['names' => 'insurance-premiums-general']);
        Route::resource('policy/insurance-documents/{policy_id}/{tbl_key}/document', 'PolicyDocumentsController', ['names' => 'insurance-documents-general']);
        Route::get('policy/insurance-terminate/{policy_id}/{tbl_key}/terminate', 'TerminatePolicyController@terminate')->name('insurance-terminate-general.form');
        Route::post('policy/insurance-terminate/{policy_id}/{tbl_key}/terminate', 'TerminatePolicyController@terminateSave')->name('insurance-terminate-general.save');

        // Insurance Terminate 
        // Route::get('life-insurance-traditional/{policy_id}/terminate/policy', 'LifeInsuranceTraditionalController@terminate')->name('life-insurance-traditional.terminate');
        
        
        Route::resource('life-insurance-ulip', 'LifeInsuranceUlipController');
        Route::resource('life-insurance-traditional', 'LifeInsuranceTraditionalController');
    });
    Route::get('plan/anydata', 'UserPlanController@anydata')->name('plan.data');
    Route::get('plansip/{plan_id}/anydata', 'UserPlanSipController@anyData')->name('plansip.data');
    Route::get('plan/view/{id}', 'UserPlanController@show')->name('plan.view');
    Route::resource('plan', 'UserPlanController');
    Route::resource('plansip', 'UserPlanSipController');
    Route::get('main-slider/anydata', 'MainSliderController@anyData')->name('main-slider.data');
    Route::resource('main-slider', 'MainSliderController');
    Route::resource('userdocument', 'UserDocumentController');
    // TESTED
});
