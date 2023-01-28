<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords = [
         [
            'id'=>2,
            'name'=>'John',
            'type'=>'vendor',
            'vendor_id'=>1,
            'mobile'=>'97000000000',
            'email'=>'john@admin.com',
            'password'=> Hash::make('353536'),
            'image'=>'',
            'status'=>0
         ],
        ];
        Admin::insert($adminRecords);
    }
}
