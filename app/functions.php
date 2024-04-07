<?php

// 设置请求id
use Ramsey\Uuid\Uuid;

function setProjectRequestId(string $requestId): void
{
    if (empty(request()->projectRequestId)) {
        request()->projectRequestId = $requestId;
    }
}

// 获取请求id
function getProjectRequestId(): string
{
    if (isset(request()->projectRequestId)) {
        return request()->projectRequestId;
    }
    return '';
}

// 获取uuid
function getUuid(): string
{
    return str_replace('-', '', Uuid::uuid4()->toString());
}
