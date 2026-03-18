<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => '科技'],
            ['name' => '文学'],
            ['name' => '艺术'],
            ['name' => '生活'],
            ['name' => '教育'],
        ];

        DB::table('categories')->insert($categories);
    }
}
