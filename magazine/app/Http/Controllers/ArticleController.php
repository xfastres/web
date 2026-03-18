<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * 显示首页（最新文章）
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $articles = Article::with(['user', 'category'])
            ->where('status', Article::STATUS_PUBLISHED)
            ->orderBy('published_at', 'desc')
            ->limit(8)
            ->get();

        return view('home', compact('articles'));
    }

    /**
     * 显示已发布文章列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Article::with(['user', 'category'])
            ->where('status', Article::STATUS_PUBLISHED);

        // 搜索功能
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    /**
     * 显示文章详情
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::with(['user', 'category'])
            ->where('status', Article::STATUS_PUBLISHED)
            ->findOrFail($id);

        return view('articles.show', compact('article'));
    }

    /**
     * 显示投稿表单
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    /**
     * 存储新投稿
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
        ]);

        Article::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id(),
            'status' => Article::STATUS_PENDING,
        ]);

        return redirect()->route('submissions.index')
            ->with('success', '投稿成功！请等待管理员审核。');
    }
}
