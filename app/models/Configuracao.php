<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracao extends MY_Model {

    public function load_config($conf_item = null)
    {
        $json = file_get_contents('../config.json');
        $cobj = (object) json_decode($json);
        if($conf_item == null){
            return $cobj;
        } else {
            return $cobj->$conf_item;
        }
    }
    
    public function save_config($data)
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        if(write_file('../config.json', $json)){
            return true;
        } else {
            return false;
        }
    }
}