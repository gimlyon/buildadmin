<?php

namespace app\admin\controller\huoshan;

use app\common\controller\Backend;

/**
 * 火山总榜管理
 *
 * @icon fa fa-circle-o
 */
class Totalrank extends Backend
{
    
    /**
     * Totalrank模型对象
     * @var \app\common\model\huoshan\Totalrank
     */
    protected $model = null;

    protected $searchFields = 'display_id,room_id,nickname';

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\common\model\huoshan\Totalrank;
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

    /**
     * 导出
     */
    public function export()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        list($where, $sort, $order, $offset, $limit) = $this->buildparams();

        $filter_where = [];
        // 按状态筛选
        $state = $this->request->param('state');
        !empty($state)? $filter_where['state'] = $state: '';
        // 按榜单时间筛选
        $begin_time = $this->request->param('begin_time');
        $end_time = $this->request->param('end_time');
        !empty($begin_time) && !empty($end_time)? $filter_where['ranktime'] = ['between time', [$begin_time, $end_time.':59']]: '';

        $list = $this->model
            ->where($where)
            ->where($filter_where)
            ->order($sort, $order)
            ->select();

        $list = collection($list)->toArray();

        $newExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();  //创建一个新的excel文档
        $objSheet = $newExcel->getActiveSheet();  //获取当前操作sheet的对象
        // $objSheet->setTitle('管理员表');  //设置当前sheet的标题

        //设置宽度为true,不然太窄了
        $newExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $newExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $newExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $newExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $newExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

        //设置第一栏的标题
        $objSheet->setCellValue('A1', '火山号')
            ->setCellValue('B1', '火山ID')
            ->setCellValue('C1', '直播间ID')
            ->setCellValue('D1', '昵称')
            ->setCellValue('E1', '排行')
            ->setCellValue('F1', '火力')
            ->setCellValue('G1', '等级')
            ->setCellValue('H1', '备注')
            ->setCellValue('I1', '状态')
            ->setCellValue('J1', '榜单时间');

        //第二行起，每一行的值,setCellValueExplicit是用来导出文本格式的。
        //->setCellValueExplicit('C' . $key, $row['admin_password']PHPExcel_Cell_DataType::TYPE_STRING),可以用来导出数字不变格式
        foreach ($list as $key => $row) {
            $key = $key + 2;
            $objSheet->setCellValue('A' . $key, $row['display_id'])
                ->setCellValue('B' . $key, $row['short_id'])
                ->setCellValue('C' . $key, $row['room_id'])
                ->setCellValue('D' . $key, $row['nickname'])
                ->setCellValue('E' . $key, $row['rank'])
                ->setCellValue('F' . $key, $row['score'])
                ->setCellValue('G' . $key, $row['level'])
                ->setCellValue('H' . $key, $row['remark'])
                ->setCellValue('I' . $key, $this->model->getStateTextAttr($row['state'], ''))
                ->setCellValue('J' . $key, date('Y-m-d H:i:s', $row['ranktime']));
        }

        $this->downloadExcel($newExcel, '火山总榜', 'Xls');
    }

}
