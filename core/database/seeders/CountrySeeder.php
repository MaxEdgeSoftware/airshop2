<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')), true);
        foreach ($countries as $key => $country) {
            $isExist = Country::where("country_short", $key)->first();
            if(!$isExist) {
                Country::create([
                    "country_short" => $key,
                    "country_name" => $country["country"],
                    "country_code" => $country["dial_code"]
                ]);
            } 
        }
    }
}
