<?php

namespace App\Models\Entities;

use App\Core\Model;
class Features{


    public $id;
    public $name;
    public $message;
    public $data;


    public function send(){
        $this->date = date('Y-m-d H:i:s');


        $db = new Model();
        $db->_table = 'features';

        

        $db->insert([
            'name' => $this->name,
            'message' => $this->message,
            'date' => $this->date,
        ]);

        return true;
    }

    public static function getFeatures(){
         $db = new Model();
         $db->consult('SELECT * FROM features');
    }

}