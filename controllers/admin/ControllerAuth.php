<?php


namespace app\controllers\admin;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class ControllerAuth extends ControllerInit
{

    public function init()
    {
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['DELETE','POST'],
                ],
            ],
        ];
    }

    /**
     * 列表
     *
     * @return string
     */
    public function actionIndex()
    {
        $list = $this->modelClass::find()->all();

        return $this->render('index', [
            'list' => $list,
        ]);
    }

    /**
     * 详情
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 添加
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = $this->modelClass::instance();

        if(Yii::$app->request->isPost){
            if ($model->modify($model::SCENARIO_ADD)) {
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

    /**
     * 删除
     *
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $res = $this->findModel($id)->delete();
        if($res){
            $resp = [
                'code' => 0,
                'msg' => '操作成功',
                'url' => Url::toRoute('index'),
            ];
        }else{
            $resp = [
                'code' => 1,
                'msg' => '操作失败',
            ];
        }

        return json_encode($resp,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

    /**
     * 获取模型
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = $this->modelClass::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}