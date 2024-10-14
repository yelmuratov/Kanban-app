<?php
    use App\Routes\Route;
    use App\Controllers\MainController;
    use App\Controllers\AuthController;

    Route::get('/',[MainController::class,'index']);

    // Auth Routes
    Route::get('/login',[AuthController::class,'login']);
    Route::get('/register',[AuthController::class,'register']);

?>