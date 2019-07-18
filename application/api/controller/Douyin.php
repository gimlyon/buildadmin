<?php

namespace app\api\controller;

use app\common\controller\Api;

use think\Controller;
use think\Request;

/**
 * 抖音数据采集接口
 */
class Douyin extends Api
{
    protected $noNeedRight = ['*'];
    protected $noNeedLogin = ['*'];

    protected $model = null;

    protected $modelValidate = true; //是否开启Validate验证，默认是false关闭状态
    protected $modelSceneValidate = true; //是否开启模型场景验证，默认是false关闭状态

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('douyin.Giftrank');
    }
    
    /**
     * 新增礼物榜数据
     */
    public function add_gift_rank()
    {
        $params = $this->request->post();
        if (!$params){
            return json(['code'=>400, 'msg'=>'获取数据失败！']);
        }
        $result = $params['param'];
        $result = htmlspecialchars_decode($result);
        $result = json_decode($result, true);
        
        if ($result['status_code'] != 0){
            return json(['code'=>400, 'msg'=>'获取数据失败！']);
        }
        try
        {
            // 榜单时间，去除微秒
            $ranktime = round($result['extra']['now']/1000);

            $ranks = [];
            foreach ($result['data']['ranks'] as $key => $row) {
                if(isset($row['user'])){
                    $latest_data = $this->model->where('short_id', $row['user']['short_id'])->where('room_id', $params['room_id'])->where('ranktime', 'between', [$ranktime-3600, $ranktime])->value('id');
                    if(!$latest_data){
                        $data = [];
                        $data['rank'] = $row['rank'];
                        $data['score'] = $row['score'];
                        $data['avatar_thumb'] = $row['user']['avatar_thumb']['url_list'][0];
                        $data['display_id'] = $row['user']['display_id'];
                        $data['nickname'] = $row['user']['nickname'];
                        isset($row['user']['pay_grade']['new_im_icon_with_level']['url_list'][0])? $data['icon_level'] = $row['user']['pay_grade']['new_im_icon_with_level']['url_list'][0]: '';
                        $data['short_id'] = $row['user']['short_id'];
                        $data['room_id'] = $params['room_id'];
                        $data['ranktime'] = $ranktime;
                        $ranks[] = $data;
                    }
                }

            }

            if (!$ranks)
            {
                return json(['code'=>400, 'msg'=>'解析数据失败！']);
            }
            $result = $this->model->allowField(true)->saveAll($ranks);
            if ($result !== false)
            {
                return json(['code'=>200, 'msg'=>'数据保存成功。']);
            }
            else
            {
                return json(['code'=>400, 'msg'=>$this->model->getError()]);
            }
        }
        catch (\think\exception\PDOException $e)
        {
            return json(['code'=>400, 'msg'=>$e->getMessage()]);
        }
    }

}
