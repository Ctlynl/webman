<?php

// 设置请求id
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
