<?php

use App\Livewire\PostForm;
use App\Livewire\PostList;
use App\Mail\SendTestEmail;
use App\Livewire\Projects\Index;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use Illuminate\Support\Facades\Mail;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('projects', Index::class)->name('projects');

    // Posts route
    Route::get('posts', PostList::class)->name('posts.index');
    Route::get('posts/create', PostForm::class)->name('posts.create');
    Route::get('posts/{mode}/{id}', PostForm::class)->name('posts.detail');

    Route::post('livewire/upload-image', [PostController::class, 'uploadImage'])->name('livewire.upload-image');
});

require __DIR__ . '/auth.php';
