<?php

namespace app\api\controller;

use app\common\controller\Api;

/**
 * 首页接口
 */
class Index extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     *
     */
    public function index()
    {
        $this->success('请求成功');
    }

    /**
     * 首页
     *
     */
    public function get_json()
    {
        $params = $this->request->post();
        $result = $params['param'];
        $result = htmlspecialchars_decode($result);
        $result = json_decode($result, true);
        trace($result, 'warning');
    }
}
