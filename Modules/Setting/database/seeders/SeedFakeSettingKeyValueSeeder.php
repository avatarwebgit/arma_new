<?php

namespace Modules\Setting\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Setting\app\Models\Setting;

class SeedFakeSettingKeyValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            'logo'=>'logo',
            'title'=>'title',
            'favicon'=>'favicon',
            'meta_title'=>'meta_title',
            'meta_description'=>'meta_description',
            'meta_keyword'=>'meta_keyword',
            'color_header'=>'#000',
            'color_footer'=>'#000',
        ];

        foreach($array as $key => $value){
            DB::table('settings')->insert([
                'key' => $key,
                'value' => $value,
            ]);
        }



    }
}
