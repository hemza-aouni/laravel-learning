<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\MenuItem;

class CmsDefaultsSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            'privacy-policy' => 'Privacy Policy',
            'terms' => 'Terms of Service',
            'about' => 'About Us',
            'contact-us' => 'Contact Us',
        ];

        $pageModels = [];
        foreach ($pages as $key => $title) {
            $pageModels[$key] = Page::firstOrCreate(
                ['key' => $key],
                ['title' => $title, 'slug' => $key, 'content' => '<p>Content coming soon.</p>', 'is_default' => true]
            );
        }

        if (MenuItem::where('location', 'header')->count() === 0) {
            MenuItem::create(['label' => 'Home', 'url' => '/', 'location' => 'header', 'order' => 0]);
            MenuItem::create(['label' => 'Blog', 'url' => '/blog', 'location' => 'header', 'order' => 1]);
            MenuItem::create(['label' => 'Pricing', 'url' => '/#pricing', 'location' => 'header', 'order' => 2]);
            MenuItem::create(['label' => 'Contact us', 'page_id' => $pageModels['contact-us']->id, 'location' => 'header', 'order' => 3]);
        }

        if (MenuItem::where('location', 'footer')->count() === 0) {
            MenuItem::create(['label' => 'Privacy Policy', 'page_id' => $pageModels['privacy-policy']->id, 'location' => 'footer', 'order' => 0]);
            MenuItem::create(['label' => 'Terms', 'page_id' => $pageModels['terms']->id, 'location' => 'footer', 'order' => 1]);
            MenuItem::create(['label' => 'Contact us', 'page_id' => $pageModels['contact-us']->id, 'location' => 'footer', 'order' => 2]);
            MenuItem::create(['label' => 'About', 'page_id' => $pageModels['about']->id, 'location' => 'footer', 'order' => 3]);
        }
    }
}
