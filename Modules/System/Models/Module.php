<?php

namespace Modules\System\Models;

use Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Sushi\Sushi;

class Module extends Model
{
    use Sushi;
    public function getRows()
    {
        $modules = \Module::all();
        $data =[];
        foreach ($modules as $module){
            $data[]=[
                'name'=>$module->getName(),
                'description'=>$module->getDescription(),
                'type'=>$module->get('type','module'),
                'version'=>$module->get('version','dev'),
                'enabled'=>$module->isEnabled(),
                'installed'=>$module->get('installed',false)
            ];
        }

        return $data;
    }
}
