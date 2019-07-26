<?php


namespace app\controllers\admin;

use app\models\Master;

class LoginController extends ControllerInit
{

    public $layout = 'ace-login';

    /**
     * 登录
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        if(\Yii::$app->request->isPost){
            $res = Master::instance()->login();
            if($res){
                return $this->redirect(['/admin/home/index']);
            }
        }

        return $this->render('index');
    }

    /**
     * 退出
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        \Yii::$app->session->destroy();

        return $this->redirect(['index']);
    }
}