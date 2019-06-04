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
Route::get('/', 'PagesController@home');
Route::get('/home', 'PagesController@home');
Route::get('/contact','PagesController@contact');
Route::get('/platform','PagesController@platform');
Route::get('/solutions','PagesController@solutions');
Route::get('/support','PagesController@support');
Route::get('/clients','PagesController@clients');
Route::get('/pricing','PagesController@pricing');
Route::get('/account','PagesController@profile');
Route::get('/account/security','PagesController@security');
Route::get('project/{project_id}/users','GroupsController@getPermissionDocument')->middleware('auth');

//update user info
Route::post('/updateUserInfo','UserInfoUpdateController@updateUserInfo');
//update user password

Route::post('/updateUserpassword','UpdateUserpasswordController@updateUserPass');

Route::get('/forgotpassword', function () {
    return view('users.passwordForgot');
});

Route::post('/forgotpassword', 'UpdateUserpasswordController@forgotpassword');
//check user to permision document

Route::get('project/checkUser/{group_id}/{userEmail}','GroupsController@checkUser')->middleware('CheckUserForPermissionDoc');

Route::get('dataroom/User/{Name}/{Email}/{Phone}/{Company}/{Project}','GroupsController@checkRegisterUser')->middleware('checkRegisterUser');


Auth::routes();

Route::get('/dashboard', function () {
    return view('users.dashboard');
});
 
Route::get('/documents', function () {
    return view('documents.index');
});

// get recycle bin document
Route::post('/recycle/document', 'RecyclebinController@getdeletedDoc');
Route::post('/recycle/document/delete', 'RecyclebinController@deleteRecycleBinDoc');
Route::post('/recycle/document/restore', 'RecyclebinController@restoreRecycleBinDoc');
Route::post('/recycle/select_document/delete', 'RecyclebinController@deleteRecycleBinSelectedDoc');


//Favrouit documents 

Route::post('/fav/document', 'FavDocumentController@makeFavDocument');

//Create note of the document

Route::post('/note/create', 'NotesController@createNotes');

// get the documents notes . 
Route::post('/note/get', 'NotesController@GetDocumentNotes');

// delete the documents notes . 
Route::post('/note/delete', 'NotesController@DeleteDocumentNotes');

// edit the documents notes. 
Route::post('/note/edit', 'NotesController@EditDocumentNotes');

//display image file 
Route::get('/display/image', 'DocumentsController@displayImage');

//setup data room before user registration
Route::post('/setup_dataroom', 'SetRoomController@SetupDataRoomByUser');
//setup dataroom validation
Route::post('/validation/info', 'SetRoomController@setDataroomvalidation');
// create project
Route::post('/create_project', 'ProjectsController@store');
//create folder
Route::post('create_folder/new_folder', 'DocumentsController@createFolder'); 
//user project
Route::get('projects', 'ProjectsController@getUserProjects');

//auth project in
Route::post('/check/projects', 'ProjectsController@getAuthProjectsIn');
//upload file
Route::post('upload_file', 'DocumentsController@uploadFile');
//show document
Route::post('show_documents', 'DocumentsController@showDocument');
//delete document
Route::post('delete_document', 'DocumentsController@deleteDocument');
// project document
Route::get('project/{project_id}/documents', 'DocumentsController@getDocument')->middleware('auth');

Route::get('project/{project_id}/documents/action', 'DocumentsController@getDocumentAction')->middleware('auth');


//file view route
Route::get('file_view/{project_id}/Open_viewer/{file_id}', 'DocumentsController@documentView');

//dwonload
Route::post('project/documents/download',[
    'as' => 'getentry', 'uses' => 'DocumentsController@download']);
//get the side bar folders
Route::post('project_documents', 'DocumentsController@getFolderAfterAction');

// Document permission routes
Route::post('get_permission_tree', 'DocumentsController@folderFileTree');
Route::post('set_permission', 'PermissionController@set_permission');
// Route::post('display_set_permission', 'PermissionController@getPermission');


//end
Route::post('move_documents', 'DocumentsController@move_documents');
Route::post('copy_documents', 'DocumentsController@copy_documents');
Route::post('rename_documents', 'DocumentsController@rename_documents');
Route::post('extractDocument', 'DocumentsController@extractDocument');
Route::post('extractDocument', 'DocumentsController@extractDocument');
Route::get('project/delete/{id}',  'ProjectsController@deleteProject');
Route::get('project/edit/{id}',  'ProjectsController@editProject');
Route::post('project/update',  'ProjectsController@updateProject');

// search document route

Route::post('doc/search_doc_content',  'DocumentsController@SearchDocument');
Route::post('fav/search_doc_content',  'DocumentsController@SearchFavDocument');

//group routes
Route::post('create_group', 'GroupsController@store');
Route::post('invite_users', 'GroupsController@GroupInvites');
Route::get('get_groups/{id}', 'GroupsController@getGroups');
Route::post('/groups/get_group_info', 'GroupsController@getGroupInfo');
Route::post('/users/get_user_info', 'GroupsController@getUserInfo');

Route::post('/delete_group', 'GroupsController@deleteGroup');
Route::post('/get_allgroups', 'GroupsController@getAllGroups');

Route::post('/get_group_users', 'GroupsController@GroupsUsersGet');
Route::post('/select_group_users', 'GroupsController@SelectGroupsUsers');

Route::post('/user/move_to_group', 'GroupsController@MoveUser');
Route::post('/change_groupName', 'GroupsController@ChangeGroupName');
Route::post('/change_groupRole', 'GroupsController@ChangeGroupRole');

Route::post('update/collaboration_setting', 'GroupsController@ChangeCollaborationSetting');
Route::post('/update/access_setting', 'GroupsController@ChangeAccessRoomSetting');
Route::post('/update/quesAns_setting', 'GroupsController@ChangeQuesAnsSetting');

Route::post('/update/member/access_setting', 'GroupsController@ChangeMemberAccessSetting');

Route::post('/member/quesAns_setting', 'GroupsController@MembersChangeQuesAnsSetting');
// all project all users
Route::post('/project_users', 'GroupsController@getAllUserInProject');


// Question and answer route
Route::post('send_question', 'QuestionsController@create_Question');

//question answer route.
Route::get('project/{project_id}/questions','QuestionsController@getQuestions')->middleware('auth');

Route::post('/show_questions','QuestionsController@getAllQuestions');

//delete question
Route::post('/delete_question','QuestionsController@deleteQuestions');

 // reply route

 Route::post('/reply_send','QuestionsController@sendReply');
 Route::post('/reply_get','QuestionsController@GetAllReply');
 Route::post('/reply_delete','QuestionsController@deleteReply');

 //create route by parmod for question searching

 Route::post('/search/question','QuestionsController@GetSearchedQues'); 


//question route end

// Reports route start

//reports route.

Route::get('project/{project_id}/reports','ReportsController@getDocsAndGroups')->middleware('auth');

Route::get('project/{project_id}/reports?folder-access','ReportsController@ReportOverview');

Route::post('/get_action','ReportsController@getAction');

Route::post('/get_group/report','ReportsController@getGroupsReports');

// Reports route end

//Recents Share File
 //Route::post('/share/documents/','ShareDocumentcontroller@shareDocsRecents');
Route::get('/shareFileRecents/{project_id}/{userEmail}/{registerChecker}/{time}','ShareDocumentcontroller@CheckShareDocsRecents');
//share document

Route::post('/share/documents/','ShareDocumentcontroller@shareDocs');
Route::get('/shareFile/{project_id}/{userEmail}/{registerChecker}/{time}','ShareDocumentcontroller@CheckShareDocs');

// Route::get('/Display/ShareDocument','ShareDocumentcontroller@ShowDocument')->middleware('CheckShareDocument');

Route::post('/Auth/getShareable/Document','ShareDocumentcontroller@ShowDocumentForAuth');

Route::get('/Overview/{access_token}/{project_id}/{email}/{document_id}/{definer}','ShareDocumentcontroller@ViewDocument')->middleware('CheckShareDocument');

Route::get('/sharedFile/{project_id}/','ShareDocumentcontroller@ShowDocumentForAuth');
//ShareFileRecents
Route::get('/shareRecents/{project_id}/','ShareDocumentcontroller@ShowDocumentForRecentAuth');

Route::get('/sharedBy_me/{project_id}/','PagesController@Shared_By');

Route::post('/sharedDoc/','ShareDocumentcontroller@GetSharedDoc');

Route::post('/GetSharedUser/','ShareDocumentcontroller@GetSharedDocsUser');

Route::post('/GetSharedUser/Permissions/','ShareDocumentcontroller@GetSharedDocsUserPermission');

Route::post('/GetShared/FoldersDoc/','ShareDocumentcontroller@GetSharedFoldersDoc');

Route::post('/share/documents/logaccess/','ShareDocumentcontroller@GetSharedDocLogAccess');

Route::post('/share/documents/update/','ShareDocumentcontroller@GetSharedDocUpdate');

//end

// Setting Route

Route::get('project/{project_id}/documents/setting/watermark','SettingController@WatermarkSetting');

Route::post('save_WaterMark/setting','SettingController@SaveWatermarkSetting');

//end


// export table

Route::get('downloadExcel/{type}', 'DocumentsController@downloadExcel');

//end


//admin dashboard 

Route::group(['namespace' => 'Admin', 'prefix' =>'' ], function()
{
   Route::get('/admin','AdminController@admin')->name('login_Page');
   Route::post('/admin/login','AdminController@adminLogin')->name('adminLogin');
   Route::get('/admin/dashboard','AdminController@dashboard')->name('dashboard');

});

Route::get('sendemail', function (){

    $data = array(
        'name' => "prodataroom",
    );

    Mail::send( [],$data, function ($message) {

        $message->from('yourEmail@domain.com', 'kidda');

        $message->to('dedar@contriverz.com')->subject('prodata room')->setBody('Hi, didar sir!');

    });

    return "Your email has been sent successfully";

});

// Route::get('storage/{filename}', function ($filename)
//     {
//         $path = storage_path('app/videos/' . $filename);

//         return \Response::make(file_get_contents($path), 200, [
//             'Content-Type' => 'video/webm',
//             'Content-Disposition' => 'inline; filename="'.$filename.'"'
//         ]);

// })->name('get-video');









