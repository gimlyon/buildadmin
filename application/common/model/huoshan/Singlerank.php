<?php

namespace app\common\model\huoshan;

use think\Model;


class Singlerank extends Model
{

    

    

    // 表名
    protected $name = 'huoshan_single_rank';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'state_text',
        'ranktime_text'
    ];
    

    
    public function getStateList()
    {
        return ['1' => __('State 1'), '2' => __('State 2')];
    }


    public function getStateTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['state']) ? $data['state'] : '');
        $list = $this->getStateList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getRanktimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['ranktime']) ? $data['ranktime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setRanktimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
