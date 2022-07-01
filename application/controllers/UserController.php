<?php
namespace application\controllers;

// * 값을 저장하는 방법

// 변수 , 컬렉션

// 변수 : 1개 값 저장
// 컬렉션 : 객체, 배열 등등 여러개 값 저장

// 컬렉션 中 시퀀스 유무

// 시퀀스O : 배열 등. 순서가 중요함 반복문을 쓸 수 있음
// 시퀀스X : 쿼리스트링 등등

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

                $dbUser->pw = null;
                $dbUser->regdt = null;
                $this->flash(_LOGINUSER, $dbUser);

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
    public function logout()
    {
        $this->flash(_LOGINUSER);
        return 'redirect:/user/signin';
    }

    public function feedwin()
    {
        $iuser = isset($_GET['iuser']) ? intval($_GET['iuser']) : 0;
        $param = ['feediuser' => $iuser, 'loginiuser' => getIuser()];
        $this->addAttribute(_DATA, $this->model->selUserProfile($param));
        $this->addAttribute(_JS, [
            'user/feedwin',
            'https://unpkg.com/swiper@8/swiper-bundle.min.js',
        ]);
        $this->addAttribute(_CSS, [
            'user/feedwin',
            'https://unpkg.com/swiper@8/swiper-bundle.min.css',
        ]);
        $this->addAttribute(_MAIN, $this->getView('user/feedwin.php'));
        return 'template/t1.php';
    }
}
