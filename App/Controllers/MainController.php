<?php
namespace App\Controllers;

use App\Models\Author\Author;
use App\Models\Book\Book;
use App\Models\Genre\Genre;
use App\Helper\Helper;

class MainController extends Helper {
    public function index() {
        $this->render('index'); 
    }

    public function kanban() {
        $this->render('Kanban/index');
    }
}

?>