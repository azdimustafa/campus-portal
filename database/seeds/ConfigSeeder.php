<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Site\Entities\Setting;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'key' => 'site_name', 
                'value' => 'Campus Portal', 
            ],
            [
                'key' => 'google_enable', 
                'value' => 'yes', 
            ],
            [
                'key' => 'cas_enable', 
                'value' => 'yes', 
            ],
        ];

        foreach ($items as $item) {
            Setting::create($item);
        }
    }
}
