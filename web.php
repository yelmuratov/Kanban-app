<?php
    use App\Routes\Route;
    use App\Controllers\MainController;
    use App\Controllers\AuthController;

    Route::get('/',[MainController::class,'index']);
    Route::get('/kanban',[MainController::class,'kanban']);
    Route::post('/createComment',[MainController::class,'createComment']);


    // Auth Routes
    Route::get('/login',[AuthController::class,'login']);
    Route::get('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login_user']);
    Route::post('/register',[AuthController::class,'register_user']);
    Route::get('/logout',[AuthController::class,'logout']);

    // Kanban Routes
    Route::post('/storeTask',[MainController::class,'storeTask']);
    Route::post('/updateTaskStatus',[MainController::class,'updateTaskStatus']);

?>