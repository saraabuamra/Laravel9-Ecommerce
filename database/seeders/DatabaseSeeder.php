<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
       // $this->call(AdminsTableSeeder::class);
        //$this->call(VendorsTableSeeder::class);
        //$this->call(VendorsBuisnessDetailsTableSeeder::class);
        //$this->call(VendorsBankDetailsTableSeeder::class);
       // $this->call(SectionsTableSeeder::class);
        //$this->call(CategoryTableSeeder::class);
       // $this->call(BrandsTableSeeder::class);
        //$this->call(ProductsTableSeeder::class);
        //$this->call(ProductsAttributesTableSeeder::class);
        //$this->call(BannersTableSeeder::class);
        $this->call(FiltersTableSeeder::class);
        //$this->call(FiltersValuesTableSeeder::class);




    }
}
