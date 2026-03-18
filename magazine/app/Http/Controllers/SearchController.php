<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * 搜索文章
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // 获取搜索关键词
        $keyword = $request->input('keyword', '');

        // 初始化查询构建器
        $query = Article::with(['user', 'category'])
            ->where('status', Article::STATUS_PUBLISHED);

        // 如果有关键词，进行搜索
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('content', 'like', '%' . $keyword . '%');
            });
        }

        // 分页显示结果，按发布时间倒序
        $articles = $query->orderBy('published_at', 'desc')
            ->paginate(10)
            ->appends(['keyword' => $keyword]);

        return view('search.results', compact('articles', 'keyword'));
    }
}
