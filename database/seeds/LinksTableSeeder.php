<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name' => '百度',
                'link_title' => '最大的中文搜索',
                'link_src' => 'www.baidu.com',
                'link_order' => 1
            ],
            [
                'link_name' => '新浪',
                'link_title' => '新浪网为全球用户24小时提供全面及时的中文资讯，内容覆盖国内外突发新闻事件、体坛赛事、娱乐时尚、产业资讯、实用信息等，设有新闻、体育、娱乐、财经、科技、房产、汽车等30多个内容频道，同时开设博客、视频、论坛等自由互动交流空间。',
                'link_src' => 'www.sina.com.cn',
                'link_order' => 2
            ]
        ];
        DB::table('links')->insert($data);
    }
}
