<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '杂志投稿系统')</title>
    <link rel="stylesheet" href="{{ asset('layui/css/layui.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Microsoft YaHei", sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        /* 导航栏样式 */
        .nav-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
        }
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            height: 60px;
        }
        .nav-logo {
            font-size: 20px;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-logo:hover {
            color: #fff;
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .nav-links a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: all 0.3s;
            font-size: 14px;
        }
        .nav-links a:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }
        .nav-links a.active {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }
        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-search {
            position: relative;
        }
        .nav-search input {
            padding: 8px 15px;
            border: none;
            border-radius: 20px;
            background: rgba(255,255,255,0.2);
            color: #fff;
            width: 180px;
            outline: none;
            font-size: 13px;
        }
        .nav-search input::placeholder {
            color: rgba(255,255,255,0.7);
        }
        .nav-user {
            position: relative;
        }
        .nav-user-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #fff;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 4px;
            transition: all 0.3s;
        }
        .nav-user-btn:hover {
            background: rgba(255,255,255,0.15);
        }
        .nav-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            min-width: 160px;
            padding: 8px 0;
            display: none;
            margin-top: 5px;
        }
        .nav-dropdown.show {
            display: block;
        }
        .nav-dropdown a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            color: #333;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
        }
        .nav-dropdown a:hover {
            background: #f5f5f5;
            color: #667eea;
        }
        .nav-dropdown hr {
            border: none;
            border-top: 1px solid #eee;
            margin: 5px 0;
        }
        /* 主内容 */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 20px 30px;
            min-height: calc(100vh - 100px);
        }
        /* 卡片样式 */
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 20px;
        }
        .card-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 500;
        }
        .card-body {
            padding: 20px;
        }
        /* 页脚 */
        .footer {
            text-align: center;
            padding: 20px;
            color: #999;
            font-size: 13px;
        }
        /* 按钮样式 */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        /* 表单样式 */
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        .form-label .required {
            color: #ff5722;
        }
        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        .form-textarea {
            min-height: 200px;
            resize: vertical;
        }
        .form-error {
            color: #ff5722;
            font-size: 12px;
            margin-top: 5px;
        }
        /* 响应式 */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            .nav-search input {
                width: 120px;
            }
            .main-container {
                padding: 70px 15px 20px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- 导航栏 -->
<header class="nav-header">
    <div class="nav-container">
        <a href="{{ route('home') }}" class="nav-logo">
            <i class="layui-icon layui-icon-read"></i>
            杂志投稿系统
        </a>
        
        <nav class="nav-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="layui-icon layui-icon-home"></i> 首页
            </a>
            <a href="{{ route('articles.index') }}" class="{{ request()->routeIs('articles.index') ? 'active' : '' }}">
                <i class="layui-icon layui-icon-list"></i> 文章列表
            </a>
        </nav>
        
        <div class="nav-right">
            <form class="nav-search" action="{{ route('articles.index') }}" method="GET">
                <input type="text" name="search" placeholder="搜索文章..." value="{{ request('search') }}">
            </form>
            
            @guest
                <a href="{{ route('login') }}" class="nav-links" style="padding: 8px 16px;">
                    <i class="layui-icon layui-icon-login"></i> 登录
                </a>
                <a href="{{ route('register') }}" class="nav-links" style="padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 4px;">
                    <i class="layui-icon layui-icon-addition"></i> 注册
                </a>
            @else
                <div class="nav-user">
                    <div class="nav-user-btn" onclick="toggleDropdown()">
                        <i class="layui-icon layui-icon-username"></i>
                        <span>{{ auth()->user()->name }}</span>
                        <i class="layui-icon layui-icon-down" style="font-size: 12px;"></i>
                    </div>
                    <div class="nav-dropdown" id="userDropdown">
                        <a href="{{ route('articles.create') }}">
                            <i class="layui-icon layui-icon-edit"></i> 投稿
                        </a>
                        <a href="{{ route('submissions.index') }}">
                            <i class="layui-icon layui-icon-file"></i> 我的投稿
                        </a>
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.pending') }}">
                                <i class="layui-icon layui-icon-auz"></i> 审核管理
                            </a>
                        @endif
                        <hr>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="layui-icon layui-icon-logout"></i> 登出
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</header>

<!-- 主内容区域 -->
<main class="main-container">
    @yield('content')
</main>

<!-- 页脚 -->
<footer class="footer">
    <p>&copy; {{ date('Y') }} 杂志投稿系统. All Rights Reserved.</p>
</footer>

<script src="{{ asset('layui/layui.js') }}"></script>
<script>
    // 下拉菜单切换
    function toggleDropdown() {
        var dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('show');
    }
    
    // 点击外部关闭下拉菜单
    document.addEventListener('click', function(e) {
        var dropdown = document.getElementById('userDropdown');
        var userBtn = document.querySelector('.nav-user');
        if (dropdown && !userBtn.contains(e.target)) {
            dropdown.classList.remove('show');
        }
    });
    
    layui.use(['element', 'form'], function(){
        var form = layui.form;
        form.render();
    });
</script>
@stack('scripts')

</body>
</html>
