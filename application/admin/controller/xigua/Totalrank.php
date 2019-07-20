<?php

namespace app\admin\controller\xigua;

use app\common\controller\Backend;

/**
 * 西瓜总榜管理
 *
 * @icon fa fa-circle-o
 */
class Totalrank extends Backend
{
    
    /**
     * Totalrank模型对象
     * @var \app\common\model\xigua\Totalrank
     */
    protected $model = null;

    protected $searchFields = 'xigua_id,room_id,nickname';

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\common\model\xigua\Totalrank;
        $this->view->assign("stateList", $this->model->getStateList());
    }
    
    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $filter_where = [];
            // 按状态筛选
            $state = $this->request->param('state');
            !empty($state)? $filter_where['state'] = $state: '';
            // 按榜单时间筛选
            $begin_time = $this->request->param('begin_time');
            $end_time = $this->request->param('end_time');
            !empty($begin_time) && !empty($end_time)? $filter_where['ranktime'] = ['between time', [$begin_time, $end_time.':59']]: '';

            $total = $this->model
                ->where($where)
                ->where($filter_where)
                ->order($sort, $order)
                ->count();

            $limit == 'All'? $limit = $total: '';

            $list = $this->model
                ->where($where)
                ->where($filter_where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

}
