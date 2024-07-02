<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Unit;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Admin::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
        ]);

        Supplier::factory(10)->create();

        // Ajouter les catégories spécifiées
        $categories = [
            ['name' => 'Noêl', 'isActive' => true, 'slug' => 'noel_slug'], // Modifier les slugs en conséquence
            ['name' => 'Paques', 'isActive' => false, 'slug' => 'paques_slug'],
            ['name' => 'St-Valentin', 'isActive' => false, 'slug' => 'st_valentin_slug'],
            ['name' => 'Halloween', 'isActive' => false, 'slug' => 'halloween_slug'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
        
        // Générer 5 unités
        for ($i = 0; $i < 5; $i++) {
            $unitName = "Unité $i";
            $unitSlug = "unite_$i";  // Vous pouvez ajuster la logique de génération du slug selon vos besoins

            Unit::create([
                'name' => $unitName,
                'slug' => $unitSlug,
            ]);
        }
        
        $materialsList = ["wood", "metal", "paper", "plastic", "glass", "cotton", "leather"];

        $categoryId = rand(1, 4); // Catégorie aléatoire de 1 à 4
        // Générez un tableau aléatoire de matériaux
        $materials = array_rand(array_flip($materialsList), rand(1, count($materialsList)));
       

        Product::factory()->create([
            'product_name' => "Boite à outils",
            'small_description' => "Kit d'outils essentiels pour les réparations domestiques", // Petite description
            'description' => "Équipez-vous pour tous vos projets de bricolage avec la Boîte à outils pratique (PC####). Cette boîte à outils compacte comprend une sélection d'outils essentiels pour des tâches telles que le vissage, la coupe, la mesure et bien plus encore. Parfaite pour les bricoleurs de tous niveaux (remplacez par votre niveau de difficulté), elle garde vos outils nécessaires organisés et facilement accessibles.", // Description complète
            'category_id' => $categoryId, // ID de la catégorie
            'unit_id' => '1',
            'product_code' => IdGenerator::generate([
                'table' => 'products',
                'field' => 'product_code',
                'length' => 4,
                'prefix' => 'PC'
            ]),
            'stock' => rand(1, 100),
            'buying_price' => rand(10, 100),
            'selling_price' => rand(50, 200),
            'isActive' => true,
            'product_image' => "https://m.media-amazon.com/images/I/61JScPbVEFL._AC_UF1000,1000_QL80_.jpg",
            'materials' => json_encode($materials),
            'difficulty' => 1,
        ]);

          Product::factory()->create([
            'product_name' => "Père Noël debout", // Product name
            'small_description' => "Décoration festive de Noël - Père Noël debout", // Short description
            'description' => "Apportez la magie de Noël dans votre foyer avec notre Père Noël debout ! Cette décoration festive représente le Père Noël dans sa posture emblématique, prêt à répandre la joie des fêtes. Fabriqué avec des matériaux de qualité et peint avec soin, ce Père Noël debout est un élément décoratif parfait pour votre intérieur ou votre extérieur. Disponible en différentes tailles pour s'adapter à tous vos besoins.", // Full description
            'category_id' => $categoryId, // Category ID (replace with the appropriate category ID for Christmas decorations)
            'unit_id' => '1', // Unit ID (likely for pieces or units)
            'product_code' => IdGenerator::generate([
                'table' => 'products',
                'field' => 'product_code',
                'length' => 4,
                'prefix' => 'PC'
            ]),
            'stock' => rand(1, 100),
            'buying_price' => rand(10, 100),
            'selling_price' => rand(50, 200),
            'isActive' => true,
            'product_image' => "https://media.but.fr/images_produits/produit-zoom/3560239478256_Q.jpg",
            'materials' => json_encode($materials),
                'difficulty' => 1,
        ]);

          Product::factory()->create([
           'product_name' => "Bonhomme de neige", // Product name
            'small_description' => "Décoration hivernale festive - Bonhomme de neige", // Short description
            'description' => "Faites entrer la magie de l'hiver chez vous avec notre Bonhomme de neige ! Cette décoration festive représente un adorable bonhomme de neige, parfait pour créer une ambiance hivernale chaleureuse dans votre intérieur ou votre extérieur. Fabriqué avec des matériaux durables et peint avec soin, ce bonhomme de neige est disponible en différentes tailles pour s'adapter à tous vos espaces. Laissez votre imagination vous guider et créez un décor hivernal féérique avec votre nouveau compagnon enneigé !", // Full description
            'category_id' => $categoryId, // Category ID (replace with the appropriate category ID for Christmas or winter decorations)
            'unit_id' => '1', // Unit ID (likely for pieces or units)
            'product_code' => IdGenerator::generate([
                'table' => 'products',
                'field' => 'product_code',
                'length' => 4,
                'prefix' => 'PC'
            ]),
            'stock' => rand(1, 100),
            'buying_price' => rand(10, 100),
            'selling_price' => rand(50, 200),
            'isActive' => true,
            'product_image' => "https://www.papo-france.com/1045-thickbox_default/bonhomme-de-neige-au-bonnet.jpg",
            'materials' => json_encode($materials),
                'difficulty' => 1,
        ]);

           Product::factory()->create([
            'product_name' => "Guirlandes rouges", // Product name
            'small_description' => "Guirlandes lumineuses rouges pour décorations festives", // Short description
            'description' => "Illuminez vos fêtes avec nos guirlandes rouges ! Ces guirlandes lumineuses LED sont parfaites pour créer une ambiance chaleureuse et festive dans votre intérieur ou votre extérieur. Disponibles en différentes longueurs pour s'adapter à vos besoins, elles se déclinent en un rouge vif et joyeux qui apportera une touche de magie à vos décorations de Noël, de mariage ou d'anniversaire. Faciles à installer et à utiliser, ces guirlandes lumineuses rouges sont un élément décoratif indispensable pour toutes vos occasions spéciales.", // Full description
            'category_id' => $categoryId, // Category ID (replace with the appropriate category ID for Christmas or winter decorations)
            'unit_id' => '1', // Unit ID (likely for packs or units)
            'product_code' => IdGenerator::generate([
                'table' => 'products',
                'field' => 'product_code',
                'length' => 4,
                'prefix' => 'PC'
            ]),
            'stock' => rand(1, 100),
            'buying_price' => rand(10, 100),
            'selling_price' => rand(50, 200),
            'isActive' => true,
            'product_image' => "https://www.texte-invitation.com/wp-content/uploads/2012/10/guirlande-noel.jpg",
            'materials' => json_encode($materials),
                'difficulty' => 3,
        ]);

         Product::factory()->create([
           'product_name' => "Guirlandes bleu", // Product name
            'small_description' => "Guirlandes lumineuses bleues pour décorations festives", // Short description
            'description' => "Ajoutez une touche de féerie à vos décorations avec nos guirlandes bleues ! Ces guirlandes lumineuses LED sont parfaites pour créer une ambiance élégante et festive dans votre intérieur ou votre extérieur. Disponibles en différentes longueurs pour s'adapter à vos besoins, elles se déclinent en un bleu scintillant qui apportera une touche de magie à vos décorations de Noël, de mariage ou d'anniversaire. Faciles à installer et à utiliser, ces guirlandes lumineuses bleues sont un élément décoratif indispensable pour toutes vos occasions spéciales.", // Full description
            'category_id' => $categoryId, // Category ID (replace with the appropriate category ID for Christmas or winter decorations)
            'unit_id' => '1', // Unit ID (likely for packs or units)
            'product_code' => IdGenerator::generate([
                'table' => 'products',
                'field' => 'product_code',
                'length' => 4,
                'prefix' => 'PC'
            ]),
            'stock' => rand(1, 100),
            'buying_price' => rand(10, 100),
            'selling_price' => rand(50, 200),
            'isActive' => true,
            'product_image' => "https://www.badaboum.fr/media/catalog/product/cache/e946e32b6959d67253cf1f4e604a63cc/_/g/_g_u_guirlande_de_noel_bleu_pour_sapin.jpg",
            'materials' => json_encode($materials),
                'difficulty' => 3,
        ]);
    
           Product::factory()->create([
            'product_name' => "Pack autocollant de Noêl", // Product name
            'small_description' => "Décorez votre intérieur avec des autocollants festifs de Noël", // Short description
            'description' => "Préparez-vous pour les fêtes de fin d'année avec notre pack d'autocollants de Noël ! Ce pack contient une variété d'autocollants colorés et amusants pour décorer votre maison, vos fenêtres, vos cadeaux et bien plus encore. Parfaits pour les enfants et les adultes, ces autocollants de Noël apporteront une touche de joie et de féerie à votre intérieur. Faciles à appliquer et à retirer, ils ne laissent aucun résidu. Laissez votre imagination vous guider et créez une ambiance festive unique pour Noël !", // Full description
            'category_id' => $categoryId, // Category ID (replace with the appropriate category ID for Christmas decorations)
            'unit_id' => '1', // Unit ID (likely for packs or units)
            'product_code' => IdGenerator::generate([
                'table' => 'products',
                'field' => 'product_code',
                'length' => 4,
                'prefix' => 'PC'
            ]),
            'stock' => rand(1, 100),
            'buying_price' => rand(10, 100),
            'selling_price' => rand(50, 200),
            'isActive' => true,
            'product_image' => "https://cdn1.vente-unique.com/thumbnails/product/1748/1748439/product_raw/xs/adhesif-decoratif_23849003.jpg",
            'materials' => json_encode($materials),
                'difficulty' => 2,
        ]);
    

    }
}
