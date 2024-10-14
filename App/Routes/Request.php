<?php
    namespace App\Routes;

    class Request{
        public $url;
        public $method;
        public $params;

        public function url(){
            $path = $_SERVER['REQUEST_URI']?? '/';
            return str_contains($path,'?') ? explode('?',$path)[0] : $path;
        }

        public function method(){
            return strtolower($_SERVER['REQUEST_METHOD']);
        }
    }
?>