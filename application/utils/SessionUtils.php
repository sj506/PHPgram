<?php

function getLoginUser()
{
  return isset($_SESSION[_LOGINUSER]) ? $_SESSION[_LOGINUSER] : null;
}

function getIuser()
{
  return getLoginUser() === null ? 0 : getLoginUser()->iuser;
}

function getMainImgsrc()
{
  return getIuser() . '/' . getLoginUser()->mainimg;
}

function getProfileImg()
{
  return isset(getLoginUser()->mainimg) ? '/static/img/profile/' . getMainImgsrc() : '/static/img/profile/defaultProfileImg_100.png';
}
