<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = public_path().'/countries.json';
        $json = json_decode(file_get_contents($path), true);
        foreach ($json as $c) {
            $data = [
                'id' => $c['id'],
                'name' => $c['name'],
                'phone_code' => $c['phone_code'],
                'currency_name' => $c['currency_name'],
                'currency' => $c['currency'],
                'currency_symbol' => $c['currency_symbol'],
                'iso2' => $c['iso2'],
                'status' => 1
            ];
            Country::create($data);
        }
    }
}
