<?php

namespace app\middleware;

use Ramsey\Uuid\Uuid;
use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class RequestMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        $projectRequestId = $request->header('X-Request-Id', Uuid::uuid4()->toString());
        setProjectRequestId($projectRequestId);
        $response = $handler($request);
        $response->header('X-Request-Id', $projectRequestId);
        return $response;
    }
}
