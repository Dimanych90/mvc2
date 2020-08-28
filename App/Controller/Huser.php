<?php

namespace App\Controller;

use Base\Controller;
use App\Model\User;

class Huser extends Controller
{
    public $view;

    public function indexAction()
    {
        $this->_render = false;
        $this->_jsonData = ['name' => 'Dima', 'id' => 123];
        $this->json();
    }


    public function loginAction()
    {
        $this->_render = false;
        echo __METHOD__;
    }

    public function registerAction()
    {
        $this->_render = false;
        $model = new User();
        $data['login'] = $_GET['login'] ?? '';
        $data['password'] = $_GET['password'] ?? '';
        $data['email'] = $_GET['email'] ?? '';

        $model->loadData($data, true);

        if (!$model->check($error)) {
            echo $error;
            return false;
        }

        $model->save();
        if ($model) {
            echo 'ok<br>';
            var_dump($model);
        } else {
            echo 'Not ok';
        };


    }

    public function huyAction()
    {
        $this->_render = false;
        echo __METHOD__;
    }


}