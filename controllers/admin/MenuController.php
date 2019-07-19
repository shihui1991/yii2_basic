<?php

namespace app\controllers\admin;

use Yii;
use app\models\Menu;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends ControllerAuth
{
    public $layout = 'ace-main';

    public $modelClass = Menu::class;

    /**
     * 列表
     *
     * @return string
     */
    public function actionIndex()
    {
        $list = Menu::find()->orderBySort()->all();

        return $this->render('index', [
            'list' => $list,
        ]);
    }

    /**
     * 添加
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate($parent_id = 0)
    {
        $this->view->params['parent_id'] = (int)$parent_id;

        return parent::actionCreate();
    }
}
