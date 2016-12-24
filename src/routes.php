<?php

$as = "";
if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
    $as = config('laraadmin.adminRoute') . '.';
}

/**
 * Connect routes with ADMIN_PANEL permission(for security) and 'Dwij\Laraadmin\Controllers' namespace
 * and '/admin' url.
 */
Route::group([
    'namespace' => 'Dwij\Laraadmin\Controllers',
    'as' => $as,
    'middleware' => ['web', 'auth', 'permission:ADMIN_PANEL', 'role:SUPER_ADMIN']
], function () {
    
    /* ================== Modules ================== */
    Route::resource('modules', 'ModuleController');
    Route::resource('module_fields', 'FieldController');
    Route::get('module_generate_crud/{model_id}', 'ModuleController@generate_crud');
    Route::get('module_generate_migr/{model_id}', 'ModuleController@generate_migr');
    Route::get('module_generate_update/{model_id}', 'ModuleController@generate_update');
    Route::get('module_generate_migr_crud/{model_id}', 'ModuleController@generate_migr_crud');
    Route::get('modules/{model_id}/set_view_col/{column_name}', 'ModuleController@set_view_col');
    Route::post('save_role_module_permissions/{id}', 'ModuleController@save_role_module_permissions');
    Route::get('save_module_field_sort/{model_id}', 'ModuleController@save_module_field_sort');
    Route::post('check_unique_val/{field_id}', 'FieldController@check_unique_val');
    Route::get('module_fields/{id}/delete', 'FieldController@destroy');
    Route::post('get_module_files/{module_id}', 'ModuleController@get_module_files');
    Route::post('module_update', 'ModuleController@update');
    Route::post('module_field_listing_show', 'FieldController@module_field_listing_show_ajax');
    
    /* ================== Code Editor ================== */
    Route::get('lacodeeditor', function () {
        if(file_exists(resource_path("views/la/editor/index.blade.php"))) {
            return redirect('laeditor');
        } else {
            // show install code editor page
            return View('la.editor.install');
        }
    });
    
    /* ================== Menu Editor ================== */
    Route::resource('la_menus', 'MenuController');
    Route::post('la_menus/update_hierarchy', 'MenuController@update_hierarchy');
    
    /* ================== Configuration ================== */
    Route::resource('la_configs', '\App\Http\Controllers\LA\LAConfigController');
    
    Route::group([
        'middleware' => 'role'
    ], function () {
        /*
        Route::get(config('laraadmin.adminRoute') . '/menu', [
            'as'   => 'menu',
            'uses' => 'LAController@index'
        ]);
        */
    });
});
