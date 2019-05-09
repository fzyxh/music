<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<?php
class dl {
    public function kugou($param) {
        require CORE_PATH . 'mcrypt.php';
        $Id = $param['id'];
        if (Mcrypt::decode($param['token'], '123456') != $param['id']) {
            send_http_status(404, TRUE);
            exit();
        }
        $Url = 'http://trackercdngz.kugou.com/i/v2/?&behavior=play&mtype=1&cmd=26&token=f7524337c1ae877929a1497cf3d5d37e5c4cb8073fc298e492a67babc376a9d4&userid=440908392&hash='.$Id.'&pid=2&vipType=6&version=9209&appid=1005&mid=65190927164643769317232905757514785123&key='.md5($Id.'57ae12eb6890223e355ccfcb74edf70d100565190927164643769317232905757514785123440908392').'&pidversion=3001';
        $Data = curl_request($Url);
        $Data = json_decode($Data, true);
        header("Expires:-1");
        header("Cache-Control:no_cache");
        header("Pragma:no-cache");
        Header('HTTP/1.1 301 Moved Permanently');
        Header('Location:' . $Data['url'][0]);
        exit();
    }
    public function kuwo($param) {
        require CORE_PATH . 'mcrypt.php';
        $Id = $param['id'];
        $Format = $param['format'];
        if (Mcrypt::decode($param['token'], '123456') != $param['id']) {
            send_http_status(404, TRUE);
            exit();
        }
        require CORE_PATH . 'DES.php';
        $DES = new DES();
        $Url = 'http://nmobi.kuwo.cn/mobi.s?f=kuwo&q='.$DES->base64_encrypt('type=convert_url2&br='.$Format.'&sig=0&rid='.$Id.'&network=wifi');
        $Data = curl_request($Url, array('ok' => 'yes'));
        header("Expires:-1");
        header("Cache-Control:no_cache");
        header("Pragma:no-cache");
        Header('HTTP/1.1 301 Moved Permanently');
        Header('Location:' . substr(explode("\r\n",$Data)[2],4));
        exit();
    }
    public function cover($param) {
        require CORE_PATH . 'mcrypt.php';
        $Id = $param['id'];
        $Type = $param['type'];
        $Name = $param['name'];
        if (Mcrypt::decode($param['token'], '123456') != $param['id']) {
            send_http_status(404, TRUE);
            exit();
        }
        if($Type === 'kuwo'){
            $Url = curl_request('http://artistpicserver.kuwo.cn/pic.web?type=rid_pic&pictype=url&size=500&rid='.$Id);
        }
        header("Expires:-1");
        header("Cache-Control:no_cache");
        header("Pragma:no-cache");
        Header('HTTP/1.1 301 Moved Permanently');
        Header('Location:' . $Url);
        exit();
    }
}