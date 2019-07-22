<?php


namespace app\queries;


use app\models\Menu;
use yii\db\ActiveQuery;

class MenuQuery extends ActiveQuery
{

    /**
     * 排序
     *
     * @param int $by
     * @return MenuQuery
     */
    public function orderBySort($by = SORT_ASC)
    {
        return $this->addOrderBy(['sort' => $by]);
    }

    /**
     * 是否限制
     *
     * @param int $isCtrl
     * @return MenuQuery
     */
    public function isCtrl($isCtrl = Menu::IS_CTRL_YES)
    {
        return $this->andWhere(['is_ctrl' => $isCtrl]);
    }

    /**
     * 是否显示
     *
     * @param int $isShow
     * @return MenuQuery
     */
    public function isShow($isShow = Menu::IS_SHOW_YES)
    {
        return $this->andWhere(['is_show' => $isShow]);
    }

    /**
     * 是否开启
     *
     * @param int $status
     * @return MenuQuery
     */
    public function active($status = Menu::STATUS_ON)
    {
        return $this->andWhere(['status' => $status]);
    }
}