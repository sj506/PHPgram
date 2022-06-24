<?php

function getUrl()
{
    return isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
}
function getUrlPaths()
{
    $getUrl = getUrl();
    return $getUrl !== '' ? explode('/', $getUrl) : '';
}

function getMethod()
{
    return $_SERVER['REQUEST_METHOD']; // post get인지 알려줌
}

function isGetOne()
{
    $urlPaths = getUrlPaths();
    if (isset($urlPaths[2])) {
        //one
        return $urlPaths[2];
    }
    return false;
}

function getParam()
{
    return isset($_GET['email']) ? $_GET['email'] : '';
}
