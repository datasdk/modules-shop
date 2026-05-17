<?php

namespace Modules\Shop\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Shop\Database\Seeders\AddressSeeder;
use Modules\Shop\Database\Seeders\TagsTableSeeder;
use Modules\Shop\Database\Seeders\BrandsTableSeeder;
use Modules\Shop\Database\Seeders\ProductsTableSeeder;
use Modules\Shop\Database\Seeders\CustomersTableSeeder;
use Modules\Shop\Database\Seeders\CategoriesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Call other seeders, e.g.
        $this->call(CustomersTableSeeder::class);
        $this->call(AddressSeeder::class);


        // Call the other seeders first
        $this->call(CategoriesTableSeeder::class);
        $this->call(BrandsTableSeeder::class);

        // Call the ProductsTableSeeder
        $this->call(ProductsTableSeeder::class);
        $this->call(TagsTableSeeder::class);
    }
} 