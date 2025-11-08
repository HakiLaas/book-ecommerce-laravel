<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiksi', 'description' => 'Buku-buku fiksi dan cerita'],
            ['name' => 'Non-Fiksi', 'description' => 'Buku-buku non-fiksi dan dokumentasi'],
            ['name' => 'Pendidikan', 'description' => 'Buku-buku pendidikan dan pembelajaran'],
            ['name' => 'Teknologi', 'description' => 'Buku-buku tentang teknologi dan komputer'],
            ['name' => 'Bisnis', 'description' => 'Buku-buku bisnis dan manajemen'],
            ['name' => 'Agama', 'description' => 'Buku-buku keagamaan'],
            ['name' => 'Anak-anak', 'description' => 'Buku-buku untuk anak-anak'],
            ['name' => 'Komik', 'description' => 'Buku komik dan manga'],
            ['name' => 'Seni', 'description' => 'Buku-buku seni dan desain'],
            ['name' => 'Kesehatan', 'description' => 'Buku-buku kesehatan dan medis'],
            ['name' => 'Kuliner', 'description' => 'Buku-buku masakan dan kuliner'],
            ['name' => 'Sastra', 'description' => 'Buku-buku sastra dan puisi'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                [
                    'description' => $category['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}

