<?php
namespace application\controllers;

class UserController extends Controller
{
    public function signin()
    {
        switch (getMethod()) {
            case _GET:
                return 'user/signin.php';

            case _POST:
                $email = $_POST['email'];
                $param = [
                    'email' => $email,
                    'pw' => $_POST['pw'],
                ];

                $dbUser = $this->model->selUser($param);

                // $this->addAttribute('data', $dbUser);

                // print_r($dbUser);
                // print $param['pw'];
                if (!$dbUser || !password_verify($param['pw'], $dbUser->pw)) {
                    return "redirect:signin?email={$email}&err";
                }

                $_SESSION[_LOGINUSER] = $dbUser;

                // print_r($_SESSION[_LOGINUSER]);

                return 'redirect:/feed/index';
        }
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
                $param['pw'] = password_hash($param['pw'], PASSWORD_BCRYPT);

                $this->model->insUser($param);

                return 'redirect:signin';
        }
    }
}
