<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

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

// 首页路由
Route::get('/', [ArticleController::class, 'home'])->name('home');

// 认证路由 - 注册（仅游客可访问）
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// 认证路由 - 登出（仅登录用户可访问）
Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    // 投稿路由 - 必须在 /articles/{id} 之前定义
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');

    // 投稿历史路由
    Route::get('/my-submissions', [SubmissionController::class, 'index'])->name('submissions.index');
});

// 文章列表路由
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// 文章详情路由 - 放在最后，避免匹配其他路由
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

// 搜索路由
Route::get('/search', [SearchController::class, 'search'])->name('search');

// 管理员路由（需要登录和管理员权限）
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // 待审核文章列表
    Route::get('/pending', [AdminController::class, 'pendingArticles'])->name('pending');

    // 文章审核操作
    Route::post('/articles/{id}/approve', [AdminController::class, 'approveArticle'])->name('articles.approve');
    Route::post('/articles/{id}/reject', [AdminController::class, 'rejectArticle'])->name('articles.reject');
});
