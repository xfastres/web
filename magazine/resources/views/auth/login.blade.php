<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户登录 - Magazine</title>
    <link rel="stylesheet" href="{{ asset('layui/css/layui.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            width: 400px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 40px;
        }
        .login-title {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 28px;
            font-weight: 600;
        }
        .layui-form-item {
            margin-bottom: 20px;
        }
        .layui-form-item .layui-input {
            height: 45px;
            line-height: 45px;
            border-radius: 5px;
        }
        .submit-btn {
            width: 100%;
            height: 45px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            font-size: 16px;
            border-radius: 5px;
        }
        .submit-btn:hover {
            opacity: 0.9;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .register-link a {
            color: #667eea;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .error-msg {
            color: #ff5722;
            font-size: 12px;
            margin-top: 5px;
        }
        .remember-me {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="login-title">用户登录</h2>
        
        @if(session('success'))
            <div class="layui-bg-green" style="padding: 10px; margin-bottom: 20px; border-radius: 5px; color: #fff;">
                {{ session('success') }}
            </div>
        @endif

        <form class="layui-form" action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="layui-form-item">
                <label class="layui-form-label"><i class="layui-icon layui-icon-email"></i></label>
                <div class="layui-input-block">
                    <input type="email" name="email" lay-verify="required|email" placeholder="请输入邮箱" 
                           autocomplete="off" class="layui-input" value="{{ old('email') }}">
                    @error('email')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><i class="layui-icon layui-icon-password"></i></label>
                <div class="layui-input-block">
                    <input type="password" name="password" lay-verify="required" placeholder="请输入密码" 
                           autocomplete="off" class="layui-input">
                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="layui-form-item remember-me">
                <div class="layui-input-block">
                    <input type="checkbox" name="remember" lay-skin="primary" title="记住我">
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" class="layui-btn submit-btn" lay-submit lay-filter="loginForm">
                        立即登录
                    </button>
                </div>
            </div>

            <div class="register-link">
                还没有账号？<a href="{{ route('register') }}">立即注册</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('layui/layui.js') }}"></script>
    <script>
        layui.use(['form', 'layer'], function(){
            var form = layui.form;
            var layer = layui.layer;

            // 表单提交
            form.on('submit(loginForm)', function(data){
                return true; // 允许表单提交
            });
        });
    </script>
</body>
</html>
