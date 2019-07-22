<?php


namespace app\controllers\admin;

use app\controllers\ControllerBase;
use app\helpers\AceHelper;
use app\helpers\ArrHelper;
use app\helpers\HtmlHelper;
use app\models\Menu;

class ControllerInit extends ControllerBase
{

    public $modelClass;

    public function init()
    {
        parent::init();

        $uri = '/'.\Yii::$app->request->getPathInfo();

        $menu = Menu::findOne(['uri' => $uri]);
        $this->view->params['curMenu'] = $menu;
        $this->view->params['breadcrumb'] = $menu->getParentsMenus();

        $this->getNav($menu);
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