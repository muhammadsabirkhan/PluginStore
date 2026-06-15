<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Mobile Phones & Tablets',
            'Laptops & Computers',
            'Audio & Headphones',
            'Wearable Technology',
            'Cameras & Photography',
            'Gaming Peripherals',
            'Home Appliances',
            'Accessories & Cables',
            'Smart Home Gadgets',
            'Office Electronics'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}