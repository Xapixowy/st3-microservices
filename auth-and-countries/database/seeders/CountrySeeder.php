<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Brazil',
                'alpha2' => 'BR',
                'alpha3' => 'BRA',
                'numeric' => '076',
                'license_plate' => 'BR',
                'domain' => 'br'
            ],
            [
                'name' => 'United States',
                'alpha2' => 'US',
                'alpha3' => 'USA',
                'numeric' => '840',
                'license_plate' => 'USA',
                'domain' => 'us'
            ],
            [
                'name' => 'Canada',
                'alpha2' => 'CA',
                'alpha3' => 'CAN',
                'numeric' => '124',
                'license_plate' => 'CAN',
                'domain' => 'ca'
            ],
            [
                'name' => 'Mexico',
                'alpha2' => 'MX',
                'alpha3' => 'MEX',
                'numeric' => '484',
                'license_plate' => 'MEX',
                'domain' => 'mx'
            ],
            [
                'name' => 'Argentina',
                'alpha2' => 'AR',
                'alpha3' => 'ARG',
                'numeric' => '032',
                'license_plate' => 'ARG',
                'domain' => 'ar'
            ],
            [
                'name' => 'Chile',
                'alpha2' => 'CL',
                'alpha3' => 'CHL',
                'numeric' => '152',
                'license_plate' => 'CHL',
                'domain' => 'cl'
            ],
            [
                'name' => 'Colombia',
                'alpha2' => 'CO',
                'alpha3' => 'COL',
                'numeric' => '170',
                'license_plate' => 'COL',
                'domain' => 'co'
            ],
            [
                'name' => 'Peru',
                'alpha2' => 'PE',
                'alpha3' => 'PER',
                'numeric' => '604',
                'license_plate' => 'PER',
                'domain' => 'pe'
            ],
            [
                'name' => 'Venezuela',
                'alpha2' => 'VE',
                'alpha3' => 'VEN',
                'numeric' => '862',
                'license_plate' => 'VEN',
                'domain' => 've'
            ],
            [
                'name' => 'Ecuador',
                'alpha2' => 'EC',
                'alpha3' => 'ECU',
                'numeric' => '218',
                'license_plate' => 'ECU',
                'domain' => 'ec'
            ],
            [
                'name' => 'Bolivia',
                'alpha2' => 'BO',
                'alpha3' => 'BOL',
                'numeric' => '068',
                'license_plate' => 'BOL',
                'domain' => 'bo'
            ],
            [
                'name' => 'Paraguay',
                'alpha2' => 'PY',
                'alpha3' => 'PRY',
                'numeric' => '600',
                'license_plate' => 'PRY',
                'domain' => 'py'
            ],
            [
                'name' => 'Uruguay',
                'alpha2' => 'UY',
                'alpha3' => 'URY',
                'numeric' => '858',
                'license_plate' => 'URY',
                'domain' => 'uy'
            ],
            [
                'name' => 'Guyana',
                'alpha2' => 'GY',
                'alpha3' => 'GUY',
                'numeric' => '328',
                'license_plate' => 'GUY',
                'domain' => 'gy'
            ],
            [
                'name' => 'Suriname',
                'alpha2' => 'SR',
                'alpha3' => 'SUR',
                'numeric' => '740',
                'license_plate' => 'SUR',
                'domain' => 'sr'
            ],
            [
                'name' => 'French Guiana',
                'alpha2' => 'GF',
                'alpha3' => 'GUF',
                'numeric' => '254',
                'license_plate' => 'GUF',
                'domain' => 'gf'
            ],
            [
                'name' => 'Falkland Islands',
                'alpha2' => 'FK',
                'alpha3' => 'FLK',
                'numeric' => '238',
                'license_plate' => 'FLK',
                'domain' => 'fk'
            ],
            [
                'name' => 'South Georgia and the South Sandwich Islands',
                'alpha2' => 'GS',
                'alpha3' => 'SGS',
                'numeric' => '239',
                'license_plate' => 'SGS',
                'domain' => 'gs'
            ],
            [
                'name' => 'Poland',
                'alpha2' => 'PL',
                'alpha3' => 'POL',
                'numeric' => '616',
                'license_plate' => 'PL',
                'domain' => 'pl'
            ]
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
