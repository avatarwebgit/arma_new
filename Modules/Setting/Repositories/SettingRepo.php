<?php

namespace Modules\Setting\Repositories;

use Illuminate\Http\Client\Request;
use Modules\Setting\App\Models\Setting;



class SettingRepos
{

    public function update($array)
    {
        foreach ($array as $key => $value) {
            
         Setting::where("key", $key)->update(["value"=> $value]);

        }
        return true;
    }

   





}
