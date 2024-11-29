<?php

use App\Http\Controllers\Api\V1\Post\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('posts', PostController::class);

