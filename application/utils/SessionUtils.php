<?php

function getLoginUser()
{
    return $_SESSION[_LOGINUSER];
}

function getIuser()
{
    return getLoginUser()->iuser;
}

function getMainImgsrc()
{
    return getIuser() . '/' . getLoginUser()->mainimg;
}

function getProfileImg()
{
    return isset(getLoginUser()->mainimg) ? '/static/img/profile/' . getMainImgsrc() : '/static/img/profile/defaultProfileImg_100.png';
}
