<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('couriers')->insert([[
            'courier_code'=> "jne",
            'courier_name'=> "JNE Express",
        ],
        [
            'courier_code'=> "pos",
            'courier_name'=> "POS Indonesia",
        ],
        [
            'courier_code'=> "jnt",
            'courier_name'=> "J&T Express Indonesia",
        ],
        [
            'courier_code'=> "sicepat",
            'courier_name'=> "SiCepat",
        ],
        [
            'courier_code'=> "tiki",
            'courier_name'=> "TIKI",
        ],
        [
            'courier_code'=> "anteraja",
            'courier_name'=> "AnterAja",
        ],
        [
            'courier_code'=> "wahana",
            'courier_name'=> "Wahana",
        ],
        [
            'courier_code'=> "ninja",
            'courier_name'=> "Ninja Express",
        ],
        [
            'courier_code'=> "lion",
            'courier_name'=> "Lion Parcel",
        ],
        [
            'courier_code'=> "pcp",
            'courier_name'=> "PCP Express",
        ],
        [
            'courier_code'=> "jet",
            'courier_name'=> "JET Express",
        ],
        [
            'courier_code'=> "rex",
            'courier_name'=> "REX Express",
        ],
        [
            'courier_code'=> "first",
            'courier_name'=> "First Logistics",
        ],
        [
            'courier_code'=> "ide",
            'courier_name'=> "ID Express",
        ],
        [
            'courier_code'=> "spx",
            'courier_name'=> "Shopee Express",
        ],
        [
            'courier_code'=> "kgx",
            'courier_name'=> "KGXpress",
        ],
        [
            'courier_code'=> "sap",
            'courier_name'=> "SAP Express",
        ],
         [
            'courier_code'=> "rpx",
            'courier_name'=> "RPX",
        ]]);
    }
}
