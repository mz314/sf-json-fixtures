<?php
namespace MZ314\JSonFixturesBundle\Services\Helpers;

class JsonHelper 
{
    public function addDefaults($data) {
        $defaults = [
            'namespace'=>'',
            'pkForce'=>false,
            'mode'=>'replace',
            'entries'=>[],
        ];

        foreach($defaults as $key=>$def) {
            if(!isset($data->$key)) {
                $data->$key = $def;
            }
        }

        return $data;
    }
}