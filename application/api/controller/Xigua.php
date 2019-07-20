<?php

namespace app\api\controller;

use app\common\controller\Api;

use think\Controller;
use think\Request;

/**
 * 西瓜数据采集接口
 */
class Xigua extends Api
{
    protected $noNeedRight = ['*'];
    protected $noNeedLogin = ['*'];

    protected $model = null;

    protected $modelValidate = true; //是否开启Validate验证，默认是false关闭状态
    protected $modelSceneValidate = true; //是否开启模型场景验证，默认是false关闭状态

    public function _initialize()
    {
        parent::_initialize();
    }
    
    /**
     * 新增本场榜数据
     */
    public function add_single_rank()
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
        $this->model = model('xigua.Singlerank');
        try
        {
            // 榜单时间，去除微秒
            $ranktime = round($result['extra']['now']/1000);

            $ranks = [];
            foreach ($result['data']['ranks'] as $key => $row) {
                if(isset($row['user']) && $row['score']>0){
                    $latest_data = $this->model->where('xigua_id', $row['user']['id'])->where('room_id', $params['room_id'])->where('ranktime', 'between', [$ranktime-3600, $ranktime])->value('id');
                    if(!$latest_data){
                        $data = [];
                        $data['rank'] = $row['rank'];
                        $data['score'] = $row['score'];
                        $data['avatar_thumb'] = $row['user']['avatar_thumb']['url_list'][0];
                        $data['nickname'] = $row['user']['nickname'];
                        if(isset($row['user']['pay_grade']['new_im_icon_with_level']['url_list'][0])){
                            $icon_level = $row['user']['pay_grade']['new_im_icon_with_level']['url_list'][0];
                            $data['level'] = substr($icon_level, strpos($icon_level, 'level_')+6, strpos($icon_level, '.png'));
                        }
                        $data['xigua_id'] = $row['user']['id'];
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

    /**
     * 新增周榜数据
     */
    public function add_week_rank()
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
        $this->model = model('xigua.Weekrank');
        try
        {
            // 榜单时间，去除微秒
            $ranktime = round($result['extra']['now']/1000);

            $ranks = [];
            foreach ($result['data']['ranks'] as $key => $row) {
                if(isset($row['user']) && $row['score']>0){
                    $latest_data = $this->model->where('xigua_id', $row['user']['id'])->where('room_id', $params['room_id'])->where('ranktime', 'between', [$ranktime-86400, $ranktime])->value('id');
                    if(!$latest_data){
                        $data = [];
                        $data['rank'] = $row['rank'];
                        $data['score'] = $row['score'];
                        $data['avatar_thumb'] = $row['user']['avatar_thumb']['url_list'][0];
                        $data['nickname'] = $row['user']['nickname'];
                        if(isset($row['user']['pay_grade']['new_im_icon_with_level']['url_list'][0])){
                            $icon_level = $row['user']['pay_grade']['new_im_icon_with_level']['url_list'][0];
                            $data['level'] = substr($icon_level, strpos($icon_level, 'level_')+6, strpos($icon_level, '.png'));
                        }
                        $data['xigua_id'] = $row['user']['id'];
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

    /**
     * 新增总榜数据
     */
    public function add_total_rank()
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
        $this->model = model('xigua.Totalrank');
        try
        {
            // 榜单时间，去除微秒
            $ranktime = round($result['extra']['now']/1000);

            $ranks = [];
            foreach ($result['data']['ranks'] as $key => $row) {
                if(isset($row['user']) && $row['score']>0){
                    $latest_data = $this->model->where('xigua_id', $row['user']['id'])->where('room_id', $params['room_id'])->where('ranktime', 'between', [$ranktime-86400, $ranktime])->value('id');
                    if(!$latest_data){
                        $data = [];
                        $data['rank'] = $row['rank'];
                        $data['score'] = $row['score'];
                        $data['avatar_thumb'] = $row['user']['avatar_thumb']['url_list'][0];
                        $data['nickname'] = $row['user']['nickname'];
                        if(isset($row['user']['pay_grade']['new_im_icon_with_level']['url_list'][0])){
                            $icon_level = $row['user']['pay_grade']['new_im_icon_with_level']['url_list'][0];
                            $data['level'] = substr($icon_level, strpos($icon_level, 'level_')+6, strpos($icon_level, '.png'));
                        }
                        $data['xigua_id'] = $row['user']['id'];
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
