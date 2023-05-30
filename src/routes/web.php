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

Route::get('/', 'UserController@index')->name('login');

Route::post('/authorization/login', 'Auth\LoginController@authorization')->name('authorization.login');
// FIXME: FORGOT PASSWORD. NEEDED.
/*Route::get('/forgot-password', 'Auth\ForgotPassword2Controller@forgotPassword')->name('forgot-password');
Route::post('/forgot-password-email', 'Auth\ForgotPassword2Controller@forgotPasswordEmail')->name('forgot-password-email');
Route::get('/reset-password/{pin}', 'Auth\ForgotPassword2Controller@resetPassword')->name('reset-password');
Route::post('/reset-password/{pin}', 'Auth\ForgotPassword2Controller@resetPasswordPost')->name('reset-password-post');*/
// FIXME: FORGOT PASSWORD. NEEDED END
Route::get('/read-notification', 'NewsController@readNotification')->name('read-notification');
Route::post('/seen-notification', 'NewsController@seenNotification')->name('seen-notification');

Route::group(['middleware' => ['auth']], function () {

    Route::group(['name' => 'ccms.'], function() {

        //setup routes
        Route::group(['name' => 'setup.', 'prefix' => 'setup'], function() {
            //Setup routes
//            Route::get('/categories', 'Ccms\Setup\CategoryController@index')->name('category.index');
//            Route::post('/categories-data', 'Ccms\Setup\CategoryController@list')->name('category.data');
//
//            Route::post('/categories/store', 'Ccms\Setup\CategoryController@store')->name('category.store');
//            Route::put('/categories-update/{id}', 'Ccms\Setup\CategoryController@store')->name('category.update');

            Route::get('/category', 'Ccms\Setup\CategoryController@index')->name('category-index');
            Route::get('/category/{id}', 'Ccms\Setup\CategoryController@edit')->name('category-edit');
            Route::post('/category', 'Ccms\Setup\CategoryController@post')->name('category-post');
            Route::post('/category-datatable-list', 'Ccms\Setup\CategoryController@dataTableList')->name('category-datatable-list');
            Route::get('/category-delete/{id}', 'Ccms\Setup\CategoryController@destroy')->name('category-delete');

            Route::get('/sub-categories', 'Ccms\Setup\SubCategoryController@index')->name('sub_category.index');
            Route::post('/sub-categories-data/{catagory_no}', 'Ccms\Setup\SubCategoryController@list')->name('sub_category.list');
            Route::get('/ajax/sub-categories-data/{catagory_no}', 'Ccms\Setup\SubCategoryController@ajaxlist')->name('sub_category.ajaxlist');
            Route::post('/sub-categories/store/{catagory_no}', 'Ccms\Setup\SubCategoryController@store')->name('sub_category.store');
            Route::put('/sub-categories-update/{catagory_no}', 'Ccms\Setup\SubCategoryController@store')->name('sub_category.update');

            //Service Engineer
            Route::get('/service-engineer-skill', 'Ccms\Setup\EngineerSkillController@index')->name('engineer_skill.index');
            Route::post('/service-engineer-skill-store', 'Ccms\Setup\EngineerSkillController@store')->name('engineer_skill.store');
            Route::put('/service-engineer-skill-update/{id}', 'Ccms\Setup\EngineerSkillController@store')->name('engineer_skill.update');
            Route::post('/engineer-skill-data', 'Ccms\Setup\EngineerSkillController@list')->name('engineer_skill.list');

            //Service Status
            Route::get('/service-status', 'Ccms\Setup\ServiceStatusController@index')->name('service_status.index');
            Route::post('/service-status-store', 'Ccms\Setup\ServiceStatusController@store')->name('service_status.store');
            Route::put('/service-status-update/{id}', 'Ccms\Setup\ServiceStatusController@store')->name('service_status.update');
            Route::post('/service-status-data', 'Ccms\Setup\ServiceStatusController@list')->name('service_status.list');

            //Service Ticket list
            Route::get('/service-ticket-list', 'Ccms\Setup\ServiceTicketActionListController@index')->name('service_ticket_action.index');
            Route::post('/service-ticket-list-store', 'Ccms\Setup\ServiceTicketActionListController@store')->name('service_ticket_action.store');
            Route::put('/service-ticket-list-update/{id}', 'Ccms\Setup\ServiceTicketActionListController@store')->name('service_ticket_action.update');
            Route::post('/service-ticket-list-data', 'Ccms\Setup\ServiceTicketActionListController@list')->name('service_ticket_action.list');

            //Ticket Priority
            Route::get('/ticket-priority', 'Ccms\Setup\TicketPriorityController@index')->name('ticket_priority.index');
            Route::post('/ticket-priority-store', 'Ccms\Setup\TicketPriorityController@store')->name('ticket_priority.store');
            Route::put('/ticket-priority-update/{id}', 'Ccms\Setup\TicketPriorityController@store')->name('ticket_priority.update');
            Route::post('/ticket-priority-data', 'Ccms\Setup\TicketPriorityController@list')->name('ticket_priority.list');

            //Ticket Type
            Route::get('/ticket-type', 'Ccms\Setup\TicketTypeController@index')->name('ticket_type.index');
            Route::post('/ticket-type-store', 'Ccms\Setup\TicketTypeController@store')->name('ticket_type.store');
            Route::put('/ticket-type-update/{id}', 'Ccms\Setup\TicketTypeController@store')->name('ticket_type.update');
            Route::post('/ticket-type-data', 'Ccms\Setup\TicketTypeController@list')->name('ticket_type.list');

            //Vendor Type
            Route::get('/vendor-type', 'Ccms\Setup\VendorTypeController@index')->name('vendor_type.index');
            Route::post('/vendor-type-store', 'Ccms\Setup\VendorTypeController@store')->name('vendor_type.store');
            Route::put('/vendor-type-update/{id}', 'Ccms\Setup\VendorTypeController@store')->name('vendor_type.update');
            Route::post('/vendor-type-data', 'Ccms\Setup\VendorTypeController@list')->name('vendor_type.list');

            //Vendors
            Route::get('/vendors', 'Ccms\Setup\VendorController@index')->name('vendors.index');
            Route::post('/vendors', 'Ccms\Setup\VendorController@store')->name('vendors.create');
            Route::put('/vendors/{id}', 'Ccms\Setup\VendorController@store')->name('vendors.update');
            Route::post('/vendors-data', 'Ccms\Setup\VendorController@list')->name('vendors.data');

            //Vendor contact persons
            Route::get('/contact-person/{vendor_no}', 'Ccms\Setup\ContactPersonController@index')->name('contact-person.index');
            Route::post('/contact-person/{vendor_no}', 'Ccms\Setup\ContactPersonController@store')->name('contact-person.create');
            Route::put('/contact-person/{vendor_no}', 'Ccms\Setup\ContactPersonController@store')->name('contact-person.update');
            Route::post('/contact-person-data/{vendor_no}', 'Ccms\Setup\ContactPersonController@list')->name('contact-person.data');

            //Service Engineer Info
            Route::get('/service-engineer-info', 'Ccms\ServiceEngineerInfoController@index')->name('service-engineer-info.index');
            Route::post('/service-engineer-info/', 'Ccms\ServiceEngineerInfoController@store')->name('service-engineer-info.create');
            Route::put('/service-engineer-info/{id}', 'Ccms\ServiceEngineerInfoController@store')->name('service-engineer-info.update');
            Route::post('/service-engineer-info-data', 'Ccms\ServiceEngineerInfoController@list')->name('service-engineer-info-datatable.data');
            Route::get('/service-engineer-info-detail-view', 'Ccms\ServiceEngineerInfoController@detailView')->name('admin.service-engineer-info.detail-view');

        });

        //Other features route
        //Equipment Add
        Route::get('/equipment-add', 'Ccms\EquipmentAddController@index')->name('equipment_add.index');
        Route::post('/equipment-add', 'Ccms\EquipmentAddController@store')->name('equipment_add.store');
        Route::put('/equipment-add/{id}', 'Ccms\EquipmentAddController@store')->name('equipment_add.update');
        Route::post('/equipment-add-data', 'Ccms\EquipmentAddController@list')->name('equipment_add.list');

        //Equipment Assigne
        Route::get('/equipment-assign', 'Ccms\EquipmentAssigneController@index')->name('equipment_assigne.index');
        Route::post('/equipment-assign', 'Ccms\EquipmentAssigneController@store')->name('equipment_assigne.store');
        Route::put('/equipment-assign/{id}', 'Ccms\EquipmentAssigneController@store')->name('equipment_assigne.update');
        Route::post('/equipment-assign-data', 'Ccms\EquipmentAssigneController@list')->name('equipment_assigne.list');

        //EquipmentList list
        Route::get('/equipment-list', 'Ccms\EquipmentListController@index')->name('equipment-list.index');
        Route::post('/equipment-list', 'Ccms\EquipmentListController@store')->name('equipment-list.create');
        Route::put('/equipment-list/{id}', 'Ccms\EquipmentListController@store')->name('equipment-list.update');
        Route::post('/equipment-list-data', 'Ccms\EquipmentListController@list')->name('equipment-list-datatable.data');

        // Equipment Requisition Master details
        Route::get('/requisition-master', 'Ccms\RequisitionMasterController@index')->name('requisition-master.index');
        Route::post('/requisition-master', 'Ccms\RequisitionMasterController@store')->name('requisition-master.create');
        Route::put('/requisition-master/{id}', 'Ccms\RequisitionMasterController@store')->name('requisition-master.update');
        Route::post('/requisition-master-data', 'Ccms\RequisitionMasterController@list')->name('requisition-master-datatable.data');

        //EmployeeInfo List
         Route::get('/employee-list-by-code', 'Ccms\EmployeeController@employeeList')->name('employee-list-by-code');

        //EquipmentList requisition details
        Route::get('/requisition-details/{requisition_mst_no}', 'Ccms\RequisitionDetailsController@index')->name('requisition-details.index');
        Route::post('/requisition-details/{requisition_mst_no}', 'Ccms\RequisitionDetailsController@store')->name('requisition-details.create');
        Route::put('/requisition-details/{requisition_mst_no}', 'Ccms\RequisitionDetailsController@store')->name('requisition-details.update');
        Route::post('/requisition-details-data/{requisition_mst_no}', 'Ccms\RequisitionDetailsController@list')->name('requisition-details-datatable.data');

        Route::group(['name' => 'admin.', 'prefix' => 'admin'], function() {
            //Admin Service Ticket
            Route::get('/service-ticket', 'Ccms\Admin\AdminTicketController@index')->name('service_ticket.index');
            Route::get('/service-ticket-detail', 'Ccms\Admin\AdminTicketController@ticketDtl')->name('service_ticket.ticket_dtl');
            Route::post('/ticket-assign-store', 'Ccms\Admin\AdminTicketController@storeTicketAssign')->name('service-ticket-assign.store');
            Route::post('/service-ticket-store', 'Ccms\Admin\AdminTicketController@store')->name('service_ticket.store');
            Route::post('/receive-equipment-store', 'Ccms\Admin\AdminTicketController@storeEqReceive')->name('equip-receive.store');
            Route::post('/third-party-store', 'Ccms\Admin\AdminTicketController@storeThirdParty')->name('third-party.store');
            Route::put('/service-ticket-update/{id}', 'Ccms\Admin\AdminTicketController@store')->name('service_ticket.update');
            Route::post('/service-ticket-data', 'Ccms\Admin\AdminTicketController@list')->name('service_ticket.list');
            Route::put('/service-ticket-comment-store', 'Ccms\Admin\AdminTicketController@storeTicketComments')->name('service-ticket.storeComment');
            Route::get('/service-ticket-remove', 'Ccms\Admin\AdminTicketController@removeServiceTicket')->name('service-ticket-remove');
            Route::get('/ticket-type-detail', 'Ccms\Admin\AdminTicketController@ticketTypeDtl')->name('ticket-type-detail');
            Route::get('/get-equipment-list', 'Ccms\Admin\AdminTicketController@getEquipmentList')->name('get-equipment-list');


            //service-ticket-assign
            Route::get('/service-ticket-assign', 'Ccms\ServiceTicketAssignController@index')->name('ticket_assign.index');
            Route::post('/service-ticket-assign-store', 'Ccms\ServiceTicketAssignController@store')->name('ticket_assign.store');
            Route::put('/service-ticket-assign-update/{id}', 'Ccms\ServiceTicketAssignController@store')->name('ticket_assign.update');
            Route::post('/service-ticket-assign-data', 'Ccms\ServiceTicketAssignController@list')->name('ticket_assign.list');

            //third party service
            Route::get('/third-party-service', 'Ccms\Admin\ThirdPartyServiceController@index')->name('admin.third_party.index');
            Route::get('/third-party-service-detail-view', 'Ccms\Admin\ThirdPartyServiceController@detailView')->name('admin.third_party.detail-view');
            Route::post('/third-party-service-store', 'Ccms\Admin\ThirdPartyServiceController@store')->name('admin.third_party.store');
            Route::put('/third-party-service-update/{id}', 'Ccms\Admin\ThirdPartyServiceController@update')->name('admin.third_party.update');
            Route::post('/third-party-service-data', 'Ccms\Admin\ThirdPartyServiceController@list')->name('admin.third_party.list');
            Route::get('/third-party-service-remove', 'Ccms\Admin\ThirdPartyServiceController@removeThirdPartyService')->name('third-party-service-remove');
            Route::get('/third-party-service-approve/{id}', 'Ccms\Admin\ThirdPartyServiceController@approve')->name('admin.third_party.approve');
            Route::get('/third-party-service-forward/{id}', 'Ccms\Admin\ThirdPartyServiceController@forward')->name('admin.third_party.forward');
            Route::get('/third-party-service-approve-modal/{id}', 'Ccms\Admin\ThirdPartyServiceController@approveModal')->name('admin.third_party.approve-modal');

            // Equipment Requisition Master
            Route::get('/requisition-master', 'Ccms\Admin\RequisitionMasterController@index')->name('admin.requisition-master.index');
            Route::get('/requisition-master-detail-view', 'Ccms\Admin\RequisitionMasterController@detailView')->name('admin.requisition-master.detail-view');
            Route::post('/requisition-master', 'Ccms\Admin\RequisitionMasterController@store')->name('admin.requisition-master.create');
            Route::put('/requisition-master/{id}', 'Ccms\Admin\RequisitionMasterController@store')->name('admin.requisition-master.update');
            Route::post('/requisition-master-data', 'Ccms\Admin\RequisitionMasterController@list')->name('admin.requisition-master-datatable.data');
            Route::get('/detail-data-remove', 'Ccms\Admin\RequisitionMasterController@removeDtlData')->name('detail-data-remove');
            Route::get('/requisition-master-data-approved', 'Ccms\Admin\RequisitionMasterController@requisitionMasterDataApproved')->name('requisition-master-data-approved');
            Route::get('/requisition-master-remove', 'Ccms\Admin\RequisitionMasterController@removeRequisition')->name('requisition-master-remove');
            Route::post('/requisition-submit', 'Ccms\Admin\RequisitionMasterController@forwardRequisition')->name('admin.requisition-submit');
            Route::post('/requisition-detail-data', 'Ccms\Admin\RequisitionMasterController@detailDatatable')->name('admin.requisition-detail-datatable.data');
            Route::post('/requisition-reject', 'Ccms\Admin\RequisitionMasterController@rejectRequisition')->name('admin.requisition-reject');


            //EquipmentList requisition details
            Route::get('/requisition-details/{requisition_mst_no}', 'Ccms\Admin\RequisitionDetailsController@index')->name('admin.requisition-details.index');
            Route::post('/requisition-details/{requisition_mst_no}', 'Ccms\Admin\RequisitionDetailsController@store')->name('admin.requisition-details.create');
            Route::put('/requisition-details/{requisition_mst_no}', 'Ccms\Admin\RequisitionDetailsController@store')->name('admin.requisition-details.update');
            Route::post('/requisition-details-data/{requisition_mst_no}', 'Ccms\Admin\RequisitionDetailsController@list')->name('admin.requisition-details-datatable.data');

            //Equipment Add
            Route::get('/equipment-add', 'Ccms\Admin\EquipmentAddController@index')->name('admin.equipment-add.index');
            Route::get('/equipment-add-detail', 'Ccms\Admin\EquipmentAddController@detail')->name('admin.equipment-add.detail');
            Route::post('/equipment-add', 'Ccms\Admin\EquipmentAddController@store')->name('admin.equipment-add.store');
            Route::put('/equipment-add/{id}', 'Ccms\Admin\EquipmentAddController@store')->name('admin.equipment-add.update');
            Route::post('/equipment-add-data', 'Ccms\Admin\EquipmentAddController@list')->name('admin.equipment-add.list');

//            //Equipment Assigne
//            Route::get('/equipment-assign', 'Ccms\Admin\EquipmentAssigneController@index')->name('admin.equipment_assigne.index');
//            Route::post('/equipment-assign', 'Ccms\Admin\EquipmentAssigneController@store')->name('admin.equipment_assigne.store');
//            Route::put('/equipment-assign/{id}', 'Ccms\Admin\EquipmentAssigneController@store')->name('admin.equipment_assigne.update');
//            Route::post('/equipment-assign-data', 'Ccms\Admin\EquipmentAssigneController@list')->name('admin.equipment_assigne.list');

            //purchase order
            Route::get('/purchase-order', 'Ccms\Admin\PurchaseOrderController@index')->name('admin.purchase-order.index');
            Route::post('/purchase-order-data', 'Ccms\Admin\PurchaseOrderController@list')->name('admin.purchase-order.list');
            Route::post('/purchase-order-item-store', 'Ccms\Admin\PurchaseOrderController@store')->name('admin.purchase-order-item.store');

            //EquipmentList list
            Route::get('/equipment-list', 'Ccms\Admin\EquipmentListController@index')->name('admin.equipment-list.index');
            Route::get('/equipment-detail', 'Ccms\Admin\EquipmentListController@detail')->name('admin.equipment-list.detail');
            Route::post('/equipment-status-update', 'Ccms\Admin\EquipmentListController@updateStatus')->name('admin.stauts-update');
            Route::post('/equipment-assign-store', 'Ccms\Admin\EquipmentListController@storeEquipmentAssign')->name('admin.equipment-assign.store');
            //Route::post('/equipment-list', 'Ccms\Admin\EquipmentListController@store')->name('admin.equipment-list.create');
            Route::get('/equipment-list-create', 'Ccms\Admin\EquipmentListController@store')->name('admin.equipment-list.create');
            Route::put('/equipment-list/{id}', 'Ccms\Admin\EquipmentListController@store')->name('admin.equipment-list.update');
            Route::post('/equipment-list-data', 'Ccms\Admin\EquipmentListController@list')->name('admin.equipment-list-datatable.data');
            Route::get('/equipment-remove', 'Ccms\Admin\EquipmentListController@removeEquipment')->name('equipment-remove');
            Route::get('/employees', 'Ccms\Admin\EquipmentListController@employees')->name('employees');
            Route::get('/employee/{empId}', 'Ccms\Admin\EquipmentListController@employee')->name('employee');
            Route::get('/equipment-invoice/download/{id}', 'Ccms\Admin\EquipmentListController@downloadFile')->name('download-equipment-invoice');
            Route::get('/inventory', 'Ccms\Admin\EquipmentListController@inventory')->name('equipment-inventory');
            Route::get('/inventory-view', 'Ccms\Admin\EquipmentListController@inventoryView')->name('equipment-inventory-view');

            //equipment service
            Route::get('/equipment-receive', 'Ccms\Admin\EquipmentReceiveController@index')->name('admin.equipment-receive.index');
            Route::get('/equipment-receive-detail', 'Ccms\Admin\EquipmentReceiveController@detail')->name('admin.equipment-receive.detail');
            Route::post('/equipment-receive-store', 'Ccms\Admin\EquipmentReceiveController@store')->name('admin.equipment-receive.store');
            Route::put('/equipment-receive-update/{id}', 'Ccms\Admin\EquipmentReceiveController@store')->name('admin.equipment-receive.update');
            Route::post('/equipment-receive-data', 'Ccms\Admin\EquipmentReceiveController@list')->name('admin.equipment-receive.list');
            Route::post('/equipment-delivery-status', 'Ccms\Admin\EquipmentReceiveController@equipmentDelivery')->name('admin.equipment-delivery-status');
            Route::get('/equipment-receive-doc/download/{id}', 'Ccms\Admin\EquipmentReceiveController@downloadReceiveFile')->name('download-receive-doc');
            Route::get('/equipment-delivery-doc/download/{id}', 'Ccms\Admin\EquipmentReceiveController@downloadDeliveryFile')->name('download-delivery-doc');


        });
        //Service Engineer Assign Tickets
        Route::get('/service-engineer-tickets', 'Ccms\ServiceEngineerAssignTicketController@index')->name('service-engineer-tickets.index');
        Route::get('/service-engineer-ticket-detail', 'Ccms\ServiceEngineerAssignTicketController@ticketDtl')->name('service-engineer-ticket.ticket-dtl');
        Route::put('/service-engineer-tickets-store', 'Ccms\ServiceEngineerAssignTicketController@store')->name('service-engineer-tickets.store');
        Route::put('/service-engineer-tickets-update/{id}', 'Ccms\ServiceEngineerAssignTicketController@store')->name('service-engineer-tickets.update');
        Route::post('/service-engineer-tickets-data', 'Ccms\ServiceEngineerAssignTicketController@list')->name('service-engineer-tickets.data');

        //My Ticket
        Route::get('/mytickets', 'Ccms\MyTicketController@index')->name('my_ticket.index');
        Route::get('/my-ticket-detail', 'Ccms\MyTicketController@ticketDtl')->name('my_ticket.ticket_dtl');
        Route::post('/my-ticket-store', 'Ccms\MyTicketController@store')->name('my-service-ticket.store');
        Route::put('/my-ticket-update/{id}', 'Ccms\MyTicketController@store')->name('my-service-ticket.update');
        Route::post('/my-ticket-data', 'Ccms\MyTicketController@list')->name('my_ticket.list');

        //third party service
        Route::get('/third-party-service', 'Ccms\ThirdPartyServiceController@index')->name('third_party.index');
        Route::post('/third-party-service-store', 'Ccms\ThirdPartyServiceController@store')->name('third_party.store');
        Route::put('/third-party-service-update/{id}', 'Ccms\ThirdPartyServiceController@store')->name('third_party.update');
        Route::post('/third-party-service-data', 'Ccms\ThirdPartyServiceController@list')->name('third_party.list');

        //equipment service
        Route::get('/equipment-receive', 'Ccms\EquipmentReceiveController@index')->name('equipment_receive.index');
        Route::post('/equipment-receive-store', 'Ccms\EquipmentReceiveController@store')->name('equipment_receive.store');
        Route::put('/equipment-receive-update/{id}', 'Ccms\EquipmentReceiveController@store')->name('equipment_receive.update');
        Route::post('/equipment-receive-data', 'Ccms\EquipmentReceiveController@list')->name('equipment_receive.list');

    });


    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('/service-ticket-data-dashboard', 'DashboardController@ticketList')->name('service_ticket.dashboard');
    Route::post('/req-data-dashboard', 'DashboardController@reqlist')->name('reqList.dashboard');
    Route::post('/service-data-dashboard', 'DashboardController@serviceList')->name('serviceList.dashboard');
    Route::post('/ticket-issue-status-dashboard', 'DashboardController@ticketIssueStatuslist')->name('ticketissuestatus.dashboard');
//    Route::post('/ticket-issue-status-dashboard', 'DashboardController@ticketIssueStatuslist')->name('admin.ticketIssueStatuslist.dashboard');
    Route::post('/eng-ticket-status-dashboard', 'DashboardController@engTicketStatuslist')->name('admin.engTicketStatuslist.dashboard');


    Route::get('/user/change-password', function () {
        return view('resetPassword');
    })->name('change-password');

    Route::post('/user/change-password', 'Auth\ResetPasswordController@resetPassword')->name('user.reset-password');
    Route::post('/report/render/{title}', 'Report\OraclePublisherController@render')->name('report');
    Route::get('/report/render/{title?}', 'Report\OraclePublisherController@render')->name('report-get');
    Route::post('/authorization/logout', 'Auth\LoginController@logout')->name('logout');

    //Report Route
    Route::group(['name' => 'report-generator', 'as' => 'ccms-report-generator.'], function () {
        Route::get('/report-generators', 'Ccms\ReportGeneratorController@index')->name('index');
        Route::get('/report-generator-params/{id}', 'Ccms\ReportGeneratorController@reportParams')->name('report-params');
    });

    Route::group(['prefix' => 'ajax', 'name' => 'ajax', 'as' => 'ajax.'], function () {
        Route::get('/employees', 'Ccms\AjaxController@employees')->name('employees');
        Route::get('/employee/{empId}', 'Ccms\AjaxController@employee')->name('employee');
        Route::get('/dept-name', 'Ccms\AjaxController@deptName')->name('dept-name');

    });

    // For News
    Route::get('/get-top-news', 'NewsController@getNews')->name('get-top-news');
    Route::get('/news-download/{id}', 'NewsController@downloadAttachment')->name('news-download');

    Route::get('/equipments/userwise', 'Ccms\ReportController@getUserWiseEquipment')->name('user_wise_equipment.index');
    Route::get('/equipments/maintenance', 'Ccms\ReportController@getServiceTicket')->name('maintenance.index');
    Route::get('/equipments/engineerlist', 'Ccms\ReportController@getServiceEngineer')->name('engineerlist.index');
    Route::get('/equipments/vendorlist', 'Ccms\ReportController@getVendorList')->name('vendorlist.index');
    Route::get('/equipments/equipmenttmaintenance', 'Ccms\ReportController@getEquipmentMaintenance')->name('EqptMaintenance.index');
    Route::get('/equipments/equipmentlist', 'Ccms\ReportController@getEquipmentList')->name('eqiplist.index');
    Route::get('/equipments/equipmentpurchase', 'Ccms\EquipmentPurchaseController@getEquipmentPurchase')->name('eqippurchase.index');
    Route::get('/equipments/requisitionlog', 'Ccms\RequisitionLogController@getRequisitionLog')->name('reqlog.index');
    Route::get('/equipments/equipmentrequest', 'Ccms\EquipmentRequestController@getEquipmentRequest')->name('eqpreq.index');
    Route::get('/equipments/equipmentreceive', 'Ccms\EquipmentReceiveController@getEquipmentReceive')->name('eqpreceive.index');
    Route::get('/equipments/engineervisit', 'Ccms\ServiceEngineerVisitController@getServiceEngineerVisit')->name('engineervisit.index');
    Route::get('/equipments/engineerassignment', 'Ccms\ServiceEngineerAssignController@getServiceEngineerAssignment')->name('engassign.index');

    Route::post('/item-variant-process', 'Ccms\Admin\RequisitionMasterController@itemVariantProcess')->name('item-variant-process');
    Route::get('/item-search-ajax', 'Ccms\Admin\RequisitionMasterController@itemSearchAjax')->name('item-search-ajax');
    Route::get('/item-view-ajax', 'Ccms\Admin\RequisitionMasterController@itemViewAjax')->name('item-view-ajax');
    Route::get('/item-variant-option', 'Ccms\Admin\RequisitionMasterController@itemVariantOption')->name('item-variant-option');

    Route::get('/requisition-inventory', 'Ccms\Admin\RequisitionMasterController@requisitionInventory')->name('requisition-inventory');
    Route::get('/requisition-inventory-view', 'Ccms\Admin\RequisitionMasterController@requisitionInventoryView')->name('requisition-inventory-view');
    Route::get('/get-inventory-details', 'Ccms\Admin\EquipmentAddController@getInventoryDetails')->name('get-inventory-details');
});

