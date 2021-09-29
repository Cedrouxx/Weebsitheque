<?php

return [

    'database' => [
        'host' => '',
        'name' => '',
        'user' => '',
        'password' => '',
        'option' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ]

    ],

    'baseUrl' => ''

];