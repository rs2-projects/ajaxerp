<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $path = public_path().'/states.json';
        $json = json_decode(file_get_contents($path), true);

        foreach ($json as $c) {
            $data = [
                'id' => $c['id'],
                'country_id' => $c['country_id'],
                'name' => $c['name'],
                'state_code' => $c['state_code'],
                'status' => 1
            ];
            State::create($data);
        }
    }
}
