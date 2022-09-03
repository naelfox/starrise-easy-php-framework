<?php

class DATABASE_CONFIG
{

    # local database
    // public static $staging = array(
    //     'host' => '192.168.1.18',
    //     'login' => 'root',
    //     'senha' => '',
    //     'banco' => '',
    // );


    # production database
    public static $production = array(
        'host' => 'localhost',
        'login' => 'user',
        'pass' => 'password',
        'database' => 'database',
    );
}