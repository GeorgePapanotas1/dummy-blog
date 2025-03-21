<?php

use App\Livewire\Pages\IndexManager;
use App\Livewire\Pages\PostCategoryManager;
use App\Livewire\Pages\PostManager;
use App\Livewire\Pages\PostShowManager;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', IndexManager::class)->name('home');
Route::get('/posts/{post}', PostShowManager::class)->name('public.posts.show');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::get('/posts', PostManager::class)->name('post');
    Route::get('/post-categories', PostCategoryManager::class)->name('post.categories');

});

require __DIR__.'/auth.php';
