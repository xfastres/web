@extends('layouts.app')

@section('title', '投稿 - dogsshit')

@section('content')
<div class="card">
    <div class="card-header">
        <h2><i class="layui-icon layui-icon-edit"></i> 投稿文章</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('articles.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label"><span class="required">*</span> 文章标题</label>
                <input type="text" name="title" class="form-input"
                       value="{{ old('title') }}" placeholder="请输入文章标题" required>
                @error('title')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label"><span class="required">*</span> 文章分类</label>
                <select name="category_id" class="form-input" required>
                    <option value="">请选择分类</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label"><span class="required">*</span> 文章正文</label>
                <textarea name="content" class="form-input form-textarea"
                          placeholder="请输入文章正文内容" required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn-primary">
                    <i class="layui-icon layui-icon-ok"></i> 提交投稿
                </button>
                <button type="reset" class="layui-btn layui-btn-primary">
                    <i class="layui-icon layui-icon-refresh"></i> 重置
                </button>
                <a href="{{ route('home') }}" class="layui-btn layui-btn-warm">
                    <i class="layui-icon layui-icon-return"></i> 返回首页
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    @if($errors->any())
        layui.use('layer', function(){
            layui.layer.msg('请检查表单填写是否正确', {icon: 2});
        });
    @endif

    @if(session('success'))
        layui.use('layer', function(){
            layui.layer.msg('{{ session('success') }}', {icon: 1});
        });
    @endif
</script>
@endpush
