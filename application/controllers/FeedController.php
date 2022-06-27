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
}
