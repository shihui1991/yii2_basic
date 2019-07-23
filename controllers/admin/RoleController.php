<?php

namespace app\controllers\admin;

use app\models\RoleMenu;
use Yii;
use app\models\Role;
use yii\web\NotFoundHttpException;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends ControllerAuth
{
    public $layout = 'ace-main';

    public $modelClass = Role::class;


    /**
     * 添加
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate($parent_id = 0)
    {
        $this->view->params['parent_id'] = (int)$parent_id;
        $model = $this->modelClass::instance();

        if(Yii::$app->request->isPost){
            if ($model->modify($model::SCENARIO_ADD)) {
                # 添加授权菜单
                if($model::IS_ROOT_YES == $model->is_root){
                    goto end;
                }
                $menuIds = Yii::$app->request->post('menu_ids');
                if($menuIds){
                    RoleMenu::instance()->batchCreate($model->id,$menuIds);
                }
                end:
                Yii::$app->session->addFlash('success', '保存成功');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->addFlash('error', '保存失败');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 修改
     *
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost){
            if ($model->modify($model::SCENARIO_EDIT)) {
                # 添加授权菜单
                RoleMenu::deleteAll(['role_id' => $model->id]);
                if($model::IS_ROOT_YES == $model->is_root){
                    goto end;
                }
                $menuIds = Yii::$app->request->post('menu_ids');
                if($menuIds){
                    RoleMenu::instance()->batchCreate($model->id,$menuIds);
                }
                end:
                Yii::$app->session->addFlash('success', '保存成功');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->addFlash('error', '保存失败');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
