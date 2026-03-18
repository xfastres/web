<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('文章标题');
            $table->text('content')->comment('文章正文');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('作者ID');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->comment('分类ID');
            $table->enum('status', ['pending', 'published', 'rejected'])->default('pending')->comment('文章状态');
            $table->string('reject_reason')->nullable()->comment('拒绝原因');
            $table->timestamp('published_at')->nullable()->comment('发布时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
