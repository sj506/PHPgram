<?php
namespace application\controllers;

class Controller
{
    protected $ctx;
    protected $model;
    private static $needLoginUrlArr = ['feed', 'user/feedwin'];

    public function __construct($action, $model)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $urlPaths = getUrl();
        foreach (static::$needLoginUrlArr as $url) {
            if (
                strpos($urlPaths, $url) === 0 &&
                !isset($_SESSION[_LOGINUSER])
            ) {
                //echo "권한이 없습니다.";
                //exit();
                $this->getView('redirect:/user/signin');
            }
        }

        $this->model = $model;
        $view = $this->$action();
        if (empty($view) && gettype($view) === 'string') {
            echo 'Controller 에러 발생';
            exit();
        }

        if (gettype($view) === 'string') {
            require_once $this->getView($view);
        } elseif (gettype($view) === 'object' || gettype($view) === 'array') {
            header('Content-Type:application/json');
            echo json_encode($view);
        }
    }

    protected function getModel($key)
    {
    }

    protected function addAttribute($key, $val)
    {
        $this->$key = $val;
    }

    protected function getView($view)
    {
        if (strpos($view, 'redirect:') === 0) {
            header('Location: ' . substr($view, 9));
            exit();
        }
        return _VIEW . $view;
    }

    protected function flash($name = '', $val = '')
    {
        if (!empty($name)) {
            //공백이 아니면
            if (!empty($val)) {
                $_SESSION[$name] = $val;
            } elseif (empty($val) && !empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }
        }
    }
}
