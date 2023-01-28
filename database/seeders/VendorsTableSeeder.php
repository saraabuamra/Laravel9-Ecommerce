<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorsRecords = [
            [
                'id'=>1,
                'name'=>'John',
                'address'=>'CP-112',
                'city'=>'New Delhi',
                'state'=>'Delhi',
                'country'=>'India',
                'pincode'=>'110001',
                'mobile'=>'97000000000',
                'email'=>'john@admin.com',
                'status'=>0,
            ],
        ];
        Vendor::insert($vendorsRecords);
    }
}
