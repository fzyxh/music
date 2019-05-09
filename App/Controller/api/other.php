<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<?php
class api {
    public function SearchList($Url, $Text, $Page, $Type) {
        $Data = curl_request($Url, array('input' => urldecode($Text), 'filter' => 'name', 'type' => $Type, 'page' => $Page), array('X-Requested-With:XMLHttpRequest', 'Referer:' . $Url));
        $Data = json_decode($Data, true);
        if ($Data['code'] !== 200) {
            if (!$Data['error']) {
                $Data['error'] = '获取数据超时，请重试！';
            }
            response('', $Data['code'], $Data['error']);
            exit();
        }
        $Data = $Data['data'];
        $List = ['list' => []];
        if (count($Data) != 0) {
            foreach ($Data as $key => $value) {
                $temp['name'] = $value['title'];
                $temp['artist'] = $value['author'];
                $temp['lrc'] = SITE_URL . 'lrc/get/type/' . $Type . '/mid/' . $value['songid'];
                if ($value['pic']) {
                    $temp['cover'] = $value['pic'];
                } else {
                    $temp['cover'] = 'http://ww1.sinaimg.cn/large/005BYqpggy1g2e5iq3k63j308c08cdfo.jpg';
                }
                $temp['url_128'] = $value['url'];
                $temp['url'] = $temp['url_128'];
                array_push($List['list'], $temp);
                unset($temp);
            }
        }
        $List['more'] = '2';
        return $List;
    }
}