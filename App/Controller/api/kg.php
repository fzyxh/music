<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<?php
class api {
    public function SearchSong($id) {
        $Data = curl_request('http://cgi.kg.qq.com/fcgi-bin/kg_ugc_getdetail?format=json&outCharset=utf-8&v=4&shareid=' . $id);
        $Data = json_decode($Data, true);
        if ($Data['code'] !== 0) {
            response('', 400, $Data['message']);
            exit();
        }
        $Data = $Data['data'];
        $List = ['list' => []];
        if (count($Data) != 0) {
            $temp['name'] = $Data['song_name'];
            $temp['artist'] = $Data['kg_nick'];
            $temp['lrc'] = SITE_URL . 'lrc/get/type/kg/mid/' . $Data['ksong_mid'];
            $temp['cover'] = $Data['cover'];
            $temp['url_128'] = $Data['playurl'];
            if ($temp['url_128'] === '') {
                $temp['url_128'] = $Data['playurl_video'];
            }
            $temp['url'] = $temp['url_128'];
            array_push($List['list'], $temp);
            unset($temp);
        }
        return $List;
    }
}