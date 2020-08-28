<?php

namespace App\Controller;

use App\Model\User;

use Base\Context;
use Base\Controller;

class Index extends Controller
{
    /** @var View */
    public $view;

    public function preAction()
    {
        $this->view->user = new User();
    }

    public function indexAction()
    {

        Context::getInstance()->getDb()->getconnection();
//        $user = new User();
        $usermodel = User::getList([18,3]);
        var_dump($usermodel);
        echo Context::getInstance()->getDb()->getLog();
    }

    public function mainAction()
    {
        echo 'main';
    }

}