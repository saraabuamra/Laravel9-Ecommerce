<?php

namespace Database\Seeders;

use App\Models\VendorsBusinessDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorsBuisnessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecord = [
            [
             'id'=>1,
             'vendor_id'=>1,
             'shop_name'=>'John Electronics Store',
             'shop_address'=>'1234-SCF',
             'shop_city'=>'New Delhi',
             'shop_state'=>'Delhi',
             'shop_country'=>'India',
             'shop_pincode'=>'110001',
             'shop_mobile'=>'97000000000',
             'shop_website'=>'sitemakers.in',
             'shop_email'=>'john@admin.com',
             'address_proof'=>'Passport',
             'address_proof_image'=>'test.jpg',
             'business_license_number'=>'132435355',
             'gst_number'=>'446466446',
             'pan_number'=>'242355346'
            ],
         ];
         VendorsBusinessDetail::insert($vendorRecord);
    }
}
