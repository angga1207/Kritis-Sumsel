<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Politik', 'color' => '#0B2545', 'icon' => 'landmark', 'children' => ['Pemerintahan', 'Pilkada', 'DPRD']],
            ['name' => 'Ekonomi', 'color' => '#16A34A', 'icon' => 'trending-up', 'children' => ['Bisnis', 'UMKM', 'Perbankan']],
            ['name' => 'Hukum & Kriminal', 'color' => '#DC2626', 'icon' => 'gavel', 'children' => ['Pengadilan', 'Kepolisian']],
            ['name' => 'Olahraga', 'color' => '#F4B400', 'icon' => 'trophy', 'children' => ['Sepak Bola', 'Bulu Tangkis']],
            ['name' => 'Pendidikan', 'color' => '#13315C', 'icon' => 'graduation-cap', 'children' => []],
            ['name' => 'Kesehatan', 'color' => '#0891B2', 'icon' => 'heart-pulse', 'children' => []],
            ['name' => 'Teknologi', 'color' => '#6D28D9', 'icon' => 'cpu', 'children' => []],
            ['name' => 'Peristiwa', 'color' => '#EA580C', 'icon' => 'flame', 'children' => []],
        ];

        foreach ($categories as $index => $category) {
            $parent = Category::firstOrCreate(
                ['name' => $category['name']],
                [
                    'color' => $category['color'],
                    'icon' => $category['icon'],
                    'order' => $index,
                    'is_active' => true,
                ]
            );

            foreach ($category['children'] as $childIndex => $childName) {
                Category::firstOrCreate(
                    ['name' => $childName],
                    [
                        'parent_id' => $parent->id,
                        'color' => $category['color'],
                        'order' => $childIndex,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
