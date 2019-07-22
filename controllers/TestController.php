<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        $url = Url::toRoute(['menu/index','id'=>1]);
        echo $url;
        die;
    }
}
