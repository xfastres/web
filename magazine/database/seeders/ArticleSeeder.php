<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        // 获取管理员用户 ID
        $adminUser = DB::table('users')->where('role', 'admin')->first();
        $userId = $adminUser ? $adminUser->id : 1;

        $articles = [
            ['title' => '探索人工智能的未来发展趋势', 'category_id' => 1],
            ['title' => '如何成为一名优秀的程序员', 'category_id' => 1],
            ['title' => '春天的诗歌 - 生命的礼赞', 'category_id' => 2],
            ['title' => '现代艺术欣赏指南', 'category_id' => 3],
            ['title' => '健康生活的 10 个小习惯', 'category_id' => 4],
            ['title' => '在线教育的优势与挑战', 'category_id' => 5],
            ['title' => '区块链技术的实际应用', 'category_id' => 1],
            ['title' => '旅行摄影技巧分享', 'category_id' => 3],
            ['title' => '家庭理财规划指南', 'category_id' => 4],
            ['title' => 'Python 入门教程', 'category_id' => 1],
        ];

        foreach ($articles as $index => $articleData) {
            Article::create([
                'title' => $articleData['title'],
                'content' => "这是文章《{$articleData['title']}》的详细内容...\n\n这是一篇测试文章，用于展示网站功能。\n\n感谢阅读！",
                'user_id' => $userId,
                'category_id' => $articleData['category_id'],
                'status' => 'published',
                'published_at' => now()->subDays($index),
            ]);
        }
    }
}
