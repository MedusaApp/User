<?php
use Personality\Models\User;

Artisan::command('make:admin {email : The email address of the user}', function ($email) {
    $user = User::whereEmail($email)->firstOrFail();
    $user->assign('admin');
    $user->assign('member');
    if ($user->membership_status != 'active') {
        $user->membership_status = 'active';
        $user->save();
    }
    $this->info($user->first_name . ' ' . $user->last_name . ' has been made an admininstrator.');
})->describe('Make the user with the specified email address an admin');

Route::get('/unauthorized', function () {
    return view('personality::auth.unauthorized');
})->name('not.authorized')->middleware('auth');

Route::group(['prefix' => 'admin', 'middleware' => 'web'], function() {
    Route::middleware('role:admin')->namespace('App\Http\Controllers')->group(function() {
        Route::get('pending')->uses('PendingController@index')->name('admin.pending');

        Route::group(['prefix' => 'api/v1'], function() {
            Route::get('pending')->uses('PendingController@getPendingUsers')->name('pending.users');
        });
    });
});
