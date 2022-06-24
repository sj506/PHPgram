<?php
namespace application\controllers;

class UserController extends Controller
{
    public function signin()
    {
        return 'user/signin.php';
    }

    public function signup()
    {
        // if (getMethod() === _GET) {
        //     return 'user/signup.php';
        // } elseif (getMethod() === _POST) {
        //     return 'redirect:signin';
        // }
        switch (getMethod()) {
            case _GET:
                return 'user/signup.php';
            case _POST:
                $param = [
                    'email' => $_POST['email'],
                    'pw' => $_POST['pw'],
                    'nm' => $_POST['nm'],
                ];
                $param['pw'] = password_hash($param['upw'], PASSWORD_BCRYPT);

                $this->model->insUser($param);

                return 'redirect:signin';
        }
    }
}
