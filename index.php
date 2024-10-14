<?php
    include 'autoload.php';
    include 'web.php';
    session_start();

    use App\App;
    $app = new App();

    $app->run();
?>