<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="E-Coniasoft API",
 *     version="0.1",
 *      @OA\Contact(
 *          email="devs@atafom.university"
 *      ),
 * ),
 *  @OA\Server(
 *      description="Testing env",
 *      url="http://localhost:8000/api/"
 *  ),
 * 
 * @OA\Server(
 *      description="Production env",
 *      url="https://api.econiasoft.com/api/"
 *  ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
