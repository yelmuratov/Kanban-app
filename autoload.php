<?php
    spl_autoload_register(function($class){
        $class = str_replace('App\\','',$class);
        $path = __DIR__ . '/App/' . str_replace('\\','/',$class) . '.php';

        if(file_exists($path)){
            require_once $path;
        }else{
            echo "Class not found: " . $path;
        }
    });
?>