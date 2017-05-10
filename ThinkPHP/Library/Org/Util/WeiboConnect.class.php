<?php
// +----------------------------------------------------------------------
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://jizhihuwai.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: @zhiwei
// +----------------------------------------------------------------------
namespace Org\Util;
class WeiboConnect {

    private function get_access_token($appkey, $appsecretkey, $code, $callback, $state=null) {
        $url = "https://api.weibo.com/oauth2/access_token";
        $param = array(
            "grant_type"    =>    "authorization_code",
            "client_id"     =>    $appkey,
            "client_secret" =>    $appsecretkey,
            "code"          =>    $code,
            "redirect_uri"  =>    $callback
        );

        $param = http_build_query($param);
        $response = $this->postUrl($url, $param);
        if($response == false) {
            return false;
        }
        $params = json_decode($response, true);
        return $params["access_token"];
    }

    private function get_openid($access_token) {
        $url = "https://api.weibo.com/oauth2/get_token_info"; 
        $param = array(
            "access_token"    => $access_token
        );

        $param = http_build_query($param);
        $response  = $this->postUrl($url, $param);
        if($response == false) {
            return false;
        }
        $params = json_decode($response, true);
        return $params['uid'];
    }

    private function authorizeURL()    {
        return 'https://api.weibo.com/oauth2/authorize';
    }
    /**
     * authorize接口
     *
     * 对应API：{@link http://open.weibo.com/wiki/Oauth2/authorize Oauth2/authorize}
     *
     * @param string $url 授权后的回调地址,站外应用需与回调地址一致,站内应用需要填写canvas page的地址
     * @param string $response_type 支持的值包括 code 和token 默认值为code
     * @param string $state 用于保持请求和回调的状态。在回调时,会在Query Parameter中回传该参数
     * @param string $display 授权页面类型 可选范围:
     *  - default		默认授权页面
     *  - mobile		支持html5的手机
     *  - popup			弹窗授权页
     *  - wap1.2		wap1.2页面
     *  - wap2.0		wap2.0页面
     *  - js			js-sdk 专用 授权页面是弹窗，返回结果为js-sdk回掉函数
     *  - apponweibo	站内应用专用,站内应用不传display参数,并且response_type为token时,默认使用改display.授权后不会返回access_token，只是输出js刷新站内应用父框架
     * @return array
     */
    public function getAuthorizeURL($client_id,  $url, $response_type = 'code', $state = NULL, $display = NULL ) {
        $params = array();
        $params['client_id'] = $client_id;
        $params['redirect_uri'] = $url;
        $params['response_type'] = $response_type;
        $params['state'] = $state;
        $params['display'] = $display;
        return $this->authorizeURL() . "?" . http_build_query($params);
    }

    public function get_user_info($token, $openid, $appkey=null, $format = "json") {
        $url = "https://api.weibo.com/2/users/show.json?access_token=$token&uid=$openid";
        /*$param = array(
            "access_token"      =>    $token,
            "uid"               =>    $openid
        );*/

        $response = $this->getUrl($url);
        if($response == false) {
            return false;
        }

        $user = json_decode($response, true);
        return $user;
    }

    public function login($appkey, $callback, $scope='') {
        $login_url = "https://api.weibo.com/oauth2/authorize?response_type=code&client_id=".$appkey."&scope=$scope&redirect_uri=" . urlencode($callback);
        redirect($login_url);
    }

    public function callback($appkey, $appsecretkey, $callback) {
        $code = $_GET['code'];

        $token = $this->get_access_token($appkey, $appsecretkey, $code, $callback);
        $openid = $this->get_openid($token);
        if(!$token || !$openid) {
            exit('get token or openid error!');
        }

        return array('openid' => $openid, 'token' => $token);
    }

    //CURL GET
    private function getUrl($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        if (!empty($options)){
            curl_setopt_array($ch, $options);
        }
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }


    //CURL POST
    private function postUrl($url,$post_data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        ob_start();
        curl_exec($ch);
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

}
