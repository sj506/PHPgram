<?php
namespace application\controllers;

class FeedController extends Controller
{
    public function index()
    {
        $this->addAttribute(_JS, ['feed/index']);
        $this->addAttribute(_MAIN, $this->getView('feed/index.php'));
        // print $this->getView('feed/index.php'); application/views/feed/index.php
        return 'template/t1.php';
    }

    public function rest()
    {
        switch (getMethod()) {
            case _POST:
                if (!is_array($_FILES) || !isset($_FILES['imgs'])) {
                    return ['result' => 0];
                }
                // $imgCount = count($_FILES['imgs']['name']);

                $param = [
                    'location' => $_POST['location'],
                    'ctnt' => $_POST['ctnt'],
                    'iuser' => getIuser(),
                ];
                $ifeed = $this->model->insFeed($param);

                foreach ($_FILES['imgs']['name'] as $key => $originFileNm) {
                    $saveDirectory = _IMG_PATH . '/feed/' . $ifeed;
                    if (!is_dir($saveDirectory)) {
                        mkdir($saveDirectory, 0777, true);
                    }
                    $tempName = $_FILES['imgs']['tmp_name'][$key];
                    $randomFileNm = getRandomFileNM($originFileNm);
                    if (
                        move_uploaded_file(
                            $tempName,
                            $saveDirectory . '/test.' . $randomFileNm
                        )
                    ) {
                        $param1 = [
                            'ifeed' => $ifeed,
                            'img' => $randomFileNm,
                        ];
                        $this->model->insFeedImg($param1);
                    }
                }

            // return ['result' => $ifeed];
        }
    }
}
