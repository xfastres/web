<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * 显示待审核文章列表
     *
     * @return \Illuminate\View\View
     */
    public function pendingArticles()
    {
        $articles = Article::with(['user', 'category'])
            ->where('status', Article::STATUS_PENDING)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.pending', compact('articles'));
    }

    /**
     * 批准文章
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveArticle($id)
    {
        $article = Article::findOrFail($id);

        $article->update([
            'status' => Article::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

        return redirect()->route('admin.pending')
            ->with('success', '文章《' . $article->title . '》已批准发布');
    }

    /**
     * 拒绝文章
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectArticle(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:500',
        ], [
            'reject_reason.required' => '请填写拒绝原因',
            'reject_reason.max' => '拒绝原因不能超过500个字符',
        ]);

        $article = Article::findOrFail($id);

        $article->update([
            'status' => Article::STATUS_REJECTED,
            'reject_reason' => $request->reject_reason,
        ]);

        return redirect()->route('admin.pending')
            ->with('success', '文章《' . $article->title . '》已被拒绝');
    }
}
