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
})->name('not.authorized');

Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'], function() {
    Route::get('pending', function (){
        return view('admin.pending');
    })->name('admin.pending');
});