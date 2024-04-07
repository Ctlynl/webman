<?php

namespace app\controller;

use app\support\ApiResponse;
use support\Response;

class IndexController
{
    public function index(): Response
    {
        return ApiResponse::success();
    }
}
