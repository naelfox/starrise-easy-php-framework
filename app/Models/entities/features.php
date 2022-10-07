<?php

namespace App\Models\Entities;

use App\Core\Model;

class Features extends Model
{

    public $id;
    public $name;
    public $message;
    public $data;

    protected $db;

    public function send()
    {
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

    public function getFeatures()
    {
        // $db = new Model();
        // $teste = $this->db->consult('SELECT * FROM features');


        // echo '<pre>';
        // print_r($teste);
        // echo '</pre>';
        // die;
        // return $db->teste;
    }
}
