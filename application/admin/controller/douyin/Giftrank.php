<?php

namespace app\admin\controller\douyin;

use app\common\controller\Backend;

/**
 * 抖音礼物榜管理
 *
 * @icon fa fa-circle-o
 */
class Giftrank extends Backend
{
    
    /**
     * Giftrank模型对象
     * @var \app\common\model\douyin\Giftrank
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\common\model\douyin\Giftrank;
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
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $total = $this->model
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->where($where)
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

        $list = $this->model
            ->where($where)
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
        $newExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        //设置第一栏的标题
        $objSheet->setCellValue('A1', '抖音号')
            ->setCellValue('B1', '抖音ID')
            ->setCellValue('C1', '直播间ID')
            ->setCellValue('D1', '昵称')
            ->setCellValue('E1', '排行')
            ->setCellValue('F1', '音浪')
            ->setCellValue('G1', '备注')
            ->setCellValue('H1', '状态')
            ->setCellValue('I1', '榜单时间');

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
                ->setCellValue('G' . $key, $row['remark'])
                ->setCellValue('H' . $key, $this->model->getStateTextAttr($row['state'], ''))
                ->setCellValue('I' . $key, date('Y-m-d H:i:s', $row['ranktime']));
        }

        $this->downloadExcel($newExcel, '抖音礼物榜', 'Xls');
    }

}
