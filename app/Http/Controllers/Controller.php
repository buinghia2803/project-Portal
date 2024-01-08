<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
     * @OA\Info(
     *      version="0.8.1",
     *      title="Zerobug OpenApi Demo Documentation",
     *      description="Swagger OpenApi description",
     *      @OA\Contact(
     *          email="vinhvv6626@co-well.com.vn"
     *      ),
     *      @OA\License(
     *          name="ZeroBlog",
     *          url="https://www.zeroblog.net"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Zerobug API Server"
     * )

     *
     * @OA\Tag(
     *     name="Zerobug",
     *     description="API Endpoints of Projects"
     * )
     */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
