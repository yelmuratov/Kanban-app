<?php
namespace App\Helper;


define('VIEW_PATH', realpath(__DIR__ . '/../Views/'));

class BaseController {
    protected function render($view, $data = []) {
        extract($data); 
        include VIEW_PATH . "/$view.php"; 
    }
}

class Helper extends BaseController {
    public static function redirect($url) {
        header("Location: $url");
        exit();
    }

    public static function dd($data) {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        die();
    }


    //check if user is logged in
    public static function checkAuth() {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
        }
    }

    //check if user is not logged in
    public static function checkGuest() {
        if (isset($_SESSION['user'])) {
            header("Location: /");
        }
    }

    //check if user is admin
    public static function checkAdmin() {
        if ($_SESSION['user'][0]['role'] != 'admin') {
            return false;
        }else{
            return true;
        }
    }




}


?>