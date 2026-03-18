#!/usr/bin/env php
<?php

/**
 * 前端视图测试脚本
 * 用于验证所有视图文件是否正确创建
 */

echo "=== 前端视图文件检查 ===\n\n";

$files = [
    'resources/views/layouts/app.blade.php' => '主布局模板',
    'resources/views/components/navbar.blade.php' => '导航栏组件',
    'resources/views/home.blade.php' => '首页视图',
    'resources/views/articles/index.blade.php' => '文章列表视图',
    'resources/views/articles/show.blade.php' => '文章详情视图',
];

$allExist = true;

foreach ($files as $file => $description) {
    $fullPath = __DIR__ . '/' . $file;
    if (file_exists($fullPath)) {
        echo "✅ {$description}: {$file}\n";
    } else {
        echo "❌ {$description}: {$file} (缺失)\n";
        $allExist = false;
    }
}

echo "\n";

// 检查路由配置
$routeFile = __DIR__ . '/routes/web.php';
if (file_exists($routeFile)) {
    $content = file_get_contents($routeFile);

    $routes = [
        "Route::get('/', [ArticleController::class, 'home'])" => '首页路由',
        "Route::get('/articles', [ArticleController::class, 'index'])" => '文章列表路由',
        "Route::get('/articles/{id}', [ArticleController::class, 'show'])" => '文章详情路由',
    ];

    echo "=== 路由配置检查 ===\n\n";

    foreach ($routes as $route => $description) {
        if (strpos($content, $route) !== false || strpos($content, str_replace('ArticleController::class, ', '', $route)) !== false) {
            echo "✅ {$description}\n";
        } else {
            echo "❌ {$description} (未找到)\n";
            $allExist = false;
        }
    }
}

echo "\n";

// 检查控制器方法
$controllerFile = __DIR__ . '/app/Http/Controllers/ArticleController.php';
if (file_exists($controllerFile)) {
    $content = file_get_contents($controllerFile);

    $methods = [
        'public function home()' => 'home 方法',
        'public function index(' => 'index 方法',
        'public function show(' => 'show 方法',
    ];

    echo "=== 控制器方法检查 ===\n\n";

    foreach ($methods as $method => $description) {
        if (strpos($content, $method) !== false) {
            echo "✅ {$description}\n";
        } else {
            echo "❌ {$description} (未找到)\n";
            $allExist = false;
        }
    }
}

echo "\n";

if ($allExist) {
    echo "🎉 所有检查通过！前端视图已成功创建。\n";
    echo "\n下一步：运行 'php artisan serve' 启动开发服务器\n";
    echo "然后访问 http://localhost:8000 查看效果\n";
} else {
    echo "⚠️  部分文件缺失，请检查上述标记为 ❌ 的项目。\n";
}

echo "\n";
