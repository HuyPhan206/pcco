<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run()
    {
        $banners = [
            [
                'title' => 'Top Cấu Hình PC Chiến Assassin’s Creed Shadows',
                'image' => 'banners/main-banner.jpg',
                'description' => null,
                'type' => 'main',
                'position' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'PC Gaming Hiệu Suất Cao',
                'image' => 'banners/small-banner-1.jpg',
                'description' => '9.990.000₫',
                'type' => 'small',
                'position' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'PC AMD Gaming',
                'image' => 'banners/small-banner-2.jpg',
                'description' => null,
                'type' => 'small',
                'position' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'PC Văn Phòng',
                'image' => 'banners/small-banner-3.jpg',
                'description' => null,
                'type' => 'small',
                'position' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'PC Giả Lập - Đồ Họa',
                'image' => 'banners/small-banner-4.jpg',
                'description' => null,
                'type' => 'small',
                'position' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'PC Workstation',
                'image' => 'banners/small-banner-5.jpg',
                'description' => null,
                'type' => 'small',
                'position' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'Màn Hình Gaming',
                'image' => 'banners/small-banner-6.jpg',
                'description' => null,
                'type' => 'small',
                'position' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}
