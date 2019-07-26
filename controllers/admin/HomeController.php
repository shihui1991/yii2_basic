<?php


namespace app\controllers\admin;


use app\models\Master;
use Yii;

class HomeController extends ControllerAuth
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 个人信息
     *
     * @return string
     */
    public function actionProfile()
    {
        $session = Yii::$app->session->get('master');
        $master = $session['master'];
        if(Yii::$app->request->isPost){
            if($master->modify(Master::SCENARIO_PROFILE)){
                Yii::$app->session->addFlash('success','保存成功');
            }else{
                Yii::$app->session->addFlash('error','保存失败');
            }
        }

        return $this->render('profile',[
            'master' => $master,
            'action' => 'profile',
        ]);
    }

    /**
     * 修改密码
     *
     * @return string
     */
    public function actionPassword()
    {
        $session = Yii::$app->session->get('master');
        $master = $session['master'];
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post('Master');
            $vali = password_verify($post['old_password'],$master->password);
            if( ! $vali){
                Yii::$app->session->addFlash('error','原密码错误');
                goto view;
            }
            if($post['password'] == $post['old_password']){
                Yii::$app->session->addFlash('error','新密码与原密码不能相同');
                goto view;
            }
            if($post['password'] != $post['password_confirm']){
                Yii::$app->session->addFlash('error','确认密码与新密码输入不一致');
                goto view;
            }
            if($master->modify(Master::SCENARIO_PASSWORD)){
                Yii::$app->session->addFlash('success','修改成功');
            }else{
                Yii::$app->session->addFlash('error','修改失败');
            }
        }

        view:
        return $this->render('profile',[
            'master' => $master,
            'action' => 'password',
        ]);
    }
}