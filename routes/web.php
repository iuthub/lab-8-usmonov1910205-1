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

use App\Http\Controllers\PostController;

//Route::get('/', function () {
//    return view('blog.index');
//});
//
//Route::get('/post/{id}', function ($id) {
//    return view('blog.post');
//});

Route::get('/', [
    'uses'=>'PostController@getIndex',
    'as'=>'blog.index'
]);

Route::get('post/{id}', [
    'uses'=>'PostController@getPost',
    'as'=>'blog.post'
]);


Route::group(['prefix'=>'admin'], function () {
    Route::get('', [
       'uses'=>'PostController@getAdminIndex',
       'as'=>'admin.index'
    ]);

    Route::get('create', [
        'uses'=>'PostController@getAdminCreate',
        'as'=>'admin.create'
    ]);

    Route::post('create', [
        'uses'=>'PostController@getAdminCreate',
        'as'=>'admin.create'
    ]);

    Route::get('edit/{id}', [
        'uses'=>'PostController@getAdminEdit',
        'as'=>'admin.edit'
    ]);

    Route::post('edit/{id}', [
        'uses'=>'PostController@getAdminUpdate',
        'as'=>'admin.update'
    ]);
});

//Route::get('/admin', function () {
//    return view('admin.index');
//});
//
//Route::get('/admin/create', function () {
//    return view('admin.create');
//});
//
//Route::get('/admin/edit/{id}', function ($id) {
//    return view('admin.edit');
//});

Route::get('/other/about', function () {
    return view('other.about');
});


Route::post('create', function (\Illuminate\Http\Request $request, \Illuminate\Validation\Factory $validator) {
    $validation = $validator->make($request->all(), [
        'title' => 'required|min :5',
        'content' => 'required|min:10'
    ]);
    if ($validation->fails()) {
        return redirect()->back()->withErrors($validation);
    }
    return redirect()->route('admin.index')->with('info', 'Post created, Title: ' . $request->input('title'));
})->name('admin.create');

Route::post('edit', function (\Illuminate\Http\Request $request, \Illuminate\Validation\Factory $validator) {
    $validation = $validator->make($request->all(), [
        'title' => 'required|min:5',
        'content' => 'required|min:10'
    ]);
    if ($validation->fails()) {
        return redirect()->back()->withErrors($validation);
    }
    return redirect()->route('admin.index')->with('info', 'Post edited, new Title: ' . $request->input('title'));
})->name('admin.update');
