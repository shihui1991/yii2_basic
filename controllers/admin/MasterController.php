<?php

namespace app\controllers\admin;

use app\models\MasterRole;
use Yii;
use app\models\Master;
use yii\web\NotFoundHttpException;

/**
 * MasterController implements the CRUD actions for Master model.
 */
class MasterController extends ControllerCommon
{
    public $modelClass = Master::class;


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
                # 添加角色
                $roleIds = Yii::$app->request->post('role_ids');
                if($roleIds){
                    MasterRole::instance()->batchCreate($model->id,$roleIds);
                }
                Yii::$app->session->addFlash('success', '保存成功');
                return $this->redirect(['index']);
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
                # 添加角色
                MasterRole::deleteAll(['master_id' => $model->id]);
                $roleIds = Yii::$app->request->post('role_ids');
                if($roleIds){
                    MasterRole::instance()->batchCreate($model->id,$roleIds);
                }
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
