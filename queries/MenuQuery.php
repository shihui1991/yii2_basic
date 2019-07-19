<?php


namespace app\queries;


use app\models\Menu;
use yii\db\ActiveQuery;

class MenuQuery extends ActiveQuery
{

    public function orderBySort($by = 'ASC')
    {
        return $this->addOrderBy(['sort' => $by]);
    }

    public function isCtrl($isCtrl = Menu::IS_CTRL_YES)
    {
        return $this->andWhere(['is_ctrl' => $isCtrl]);
    }

    public function isShow($isShow = Menu::IS_SHOW_YES)
    {
        return $this->andWhere(['is_show' => $isShow]);
    }

    public function active($status = Menu::STATUS_ON)
    {
        return $this->andWhere(['status' => $status]);
    }
}