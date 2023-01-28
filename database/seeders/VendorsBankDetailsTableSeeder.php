<?php

namespace Database\Seeders;

use App\Models\VendorsBankDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorsBankDetailsTableSeeder extends Seeder
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
             'account_holder_name'=>'John Cena',
             'bank_name'=>'ICICI',
             'account_number'=>'024353050022',
             'bank_ifsc_code'=>'24353563',
            ],
         ];
         VendorsBankDetail::insert($vendorRecord);
    }
}
