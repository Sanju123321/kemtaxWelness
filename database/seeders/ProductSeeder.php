<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Immunity
            ['name' => 'Giloy Juice',          'category' => 'immunity',  'price' => 299,  'original_price' => 399,  'rating' => 4.8, 'review_count' => 210, 'stock' => 150, 'tags' => ['Best'], 'benefits' => ['Immunity', 'Anti-viral', 'Antioxidant'], 'short_desc' => 'Pure Giloy stem juice for daily immunity boost & fever management.'],
            ['name' => 'Tulsi Drops',          'category' => 'immunity',  'price' => 199,  'original_price' => 299,  'rating' => 4.7, 'review_count' => 180, 'stock' => 200, 'tags' => ['Sale'], 'benefits' => ['Cold & Flu', 'Respiratory', 'Immunity'], 'short_desc' => 'Concentrated holy basil extract for respiratory health & immunity.'],
            ['name' => 'Chyawanprash Classic', 'category' => 'immunity',  'price' => 499,  'original_price' => 699,  'rating' => 4.9, 'review_count' => 340, 'stock' => 120, 'tags' => ['Best'], 'benefits' => ['Immunity', 'Energy', 'Anti-ageing'], 'short_desc' => 'Traditional herbal jam with 40+ herbs. India\'s number 1 immunity formula.'],
            ['name' => 'Amla Gold Capsules',   'category' => 'immunity',  'price' => 399,  'original_price' => 499,  'rating' => 4.6, 'review_count' => 150, 'stock' => 90,  'tags' => ['New'], 'benefits' => ['Vitamin C', 'Immunity', 'Antioxidant'], 'short_desc' => 'High-potency Indian gooseberry extract for daily immunity support.'],
            // Digestion
            ['name' => 'Triphala Churna',      'category' => 'digestion', 'price' => 249,  'original_price' => 349,  'rating' => 4.7, 'review_count' => 195, 'stock' => 175, 'tags' => ['Best'], 'benefits' => ['Digestion', 'Detox', 'Constipation Relief'], 'short_desc' => 'Three-fruit blend for complete digestive wellness & gentle detox.'],
            ['name' => 'Aloe Vera Juice',      'category' => 'digestion', 'price' => 299,  'original_price' => 399,  'rating' => 4.5, 'review_count' => 220, 'stock' => 160, 'tags' => ['Sale'], 'benefits' => ['Gut Health', 'Digestion', 'Skin'], 'short_desc' => 'Pure aloe vera juice for gut health, skin glow & digestion.'],
            ['name' => 'Isabgol Husk',         'category' => 'digestion', 'price' => 199,  'original_price' => null, 'rating' => 4.6, 'review_count' => 310, 'stock' => 200, 'tags' => [], 'benefits' => ['Fiber', 'Constipation', 'Cholesterol'], 'short_desc' => 'Natural psyllium husk for smooth digestion & healthy cholesterol levels.'],
            // Skin Care
            ['name' => 'Kumkumadi Oil',        'category' => 'skincare',  'price' => 899,  'original_price' => 1299, 'rating' => 4.8, 'review_count' => 175, 'stock' => 60,  'tags' => ['Best', 'Sale'], 'benefits' => ['Glow', 'Anti-ageing', 'Dark Spots'], 'short_desc' => 'Ayurvedic face oil with saffron for radiant & youthful skin.'],
            ['name' => 'Neem Face Wash',       'category' => 'skincare',  'price' => 299,  'original_price' => 399,  'rating' => 4.5, 'review_count' => 280, 'stock' => 180, 'tags' => ['New'], 'benefits' => ['Acne', 'Oil Control', 'Antibacterial'], 'short_desc' => 'Neem & turmeric face wash for acne-free, clear skin.'],
            // Hair Care
            ['name' => 'Bhringraj Hair Oil',   'category' => 'haircare',  'price' => 449,  'original_price' => 599,  'rating' => 4.7, 'review_count' => 240, 'stock' => 130, 'tags' => ['Best'], 'benefits' => ['Hair Growth', 'Anti-dandruff', 'Strengthening'], 'short_desc' => 'Bhringraj & Amla oil for hair growth, dandruff control & shine.'],
            ['name' => 'Onion Hair Serum',     'category' => 'haircare',  'price' => 599,  'original_price' => 799,  'rating' => 4.6, 'review_count' => 190, 'stock' => 100, 'tags' => ['Sale'], 'benefits' => ['Hair Fall', 'Scalp Health', 'Nourishment'], 'short_desc' => 'Onion extract serum to reduce hair fall and strengthen roots.'],
            // Joint & Bone
            ['name' => 'Shallaki Capsules',    'category' => 'joint',     'price' => 549,  'original_price' => 749,  'rating' => 4.6, 'review_count' => 145, 'stock' => 80,  'tags' => ['Best'], 'benefits' => ['Joint Pain', 'Inflammation', 'Mobility'], 'short_desc' => 'Boswellia extract capsules for joint flexibility & pain relief.'],
            ['name' => 'Ashwagandha KSM-66',   'category' => 'energy',    'price' => 699,  'original_price' => 999,  'rating' => 4.9, 'review_count' => 420, 'stock' => 200, 'tags' => ['Best'], 'benefits' => ['Stress Relief', 'Energy', 'Testosterone'], 'short_desc' => 'Clinically studied root extract for energy, vitality & stress management.'],
            // Detox
            ['name' => 'Neem Karela Jamun',    'category' => 'detox',     'price' => 349,  'original_price' => 499,  'rating' => 4.5, 'review_count' => 165, 'stock' => 140, 'tags' => ['Sale'], 'benefits' => ['Blood Sugar', 'Detox', 'Liver Health'], 'short_desc' => 'Powerful blood purifier for blood sugar management & liver detox.'],
            ['name' => 'Wheatgrass Powder',    'category' => 'detox',     'price' => 399,  'original_price' => 549,  'rating' => 4.4, 'review_count' => 130, 'stock' => 110, 'tags' => ['New'], 'benefits' => ['Chlorophyll', 'Detox', 'Energy'], 'short_desc' => 'Pure organic wheatgrass powder for alkalizing & natural detox.'],
            // Women
            ['name' => 'Shatavari Capsules',   'category' => 'women',     'price' => 499,  'original_price' => 699,  'rating' => 4.7, 'review_count' => 155, 'stock' => 95,  'tags' => ['Best'], 'benefits' => ['Hormonal Balance', 'Fertility', 'Lactation'], 'short_desc' => 'Shatavari root extract for hormonal balance & women\'s reproductive health.'],
        ];

        foreach ($products as $data) {
            $data['slug']       = Str::slug($data['name']);
            $data['status']     = 'active';
            $data['sort_order'] = 0;

            Product::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
