<?php


namespace app\controllers\admin;

use app\helpers\AceHelper;
use app\models\Menu;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class ControllerAuth extends ControllerInit
{

    public function beforeAction($action)
    {
        $res = parent::beforeAction($action);

        $uri = '/'.\Yii::$app->request->getPathInfo();

        $menu = Menu::findOne(['uri' => $uri]);
        if( !$menu){
            throw new NotFoundHttpException('无法访问');
        }

        $session = \Yii::$app->session->get('master');
        if( ! $session){
            $this->redirect('/admin/login/index')->send();
            return false;
        }
        if(Menu::IS_CTRL_YES == $menu->is_ctrl
            && !$session['isRoot']
            && !in_array($menu->id,$session['menuIds'])
        ){
            throw new UnauthorizedHttpException('无访问权限');
        }

        $this->view->params['curMenu'] = $menu;
        $this->view->params['breadcrumb'] = $menu->getParents();

        $this->getNav($menu);

        return true & $res;
    }

    /**
     * 获取导航
     *
     * @param $curMenu
     */
    protected function getNav($curMenu)
    {
        $menus = Menu::find()->isShow()->orderBySort()->all();
        $list = [];
        foreach($menus as $menu){
            $list[] = $menu->toArray();
        }

        $this->view->params['navList'] = AceHelper::makeNav($list,0,1,$curMenu->id,$curMenu->formatValForParentsIds());
    }
}