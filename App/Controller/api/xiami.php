<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<?php
class api {
    public function SearchList($text, $page) {
        $Data = curl_request('https://music-api-jwzcyzizya.now.sh/api/search/song/xiami?limit=20&page=' . $page . '&key=' . $text);
        $Data = json_decode($Data, true);
        $ListData = $Data['songList'];
        $List = ['list' => []];
        if (count($ListData) != 0) {
            foreach ($ListData as $key => $value) {
                $temp['name'] = $value['name'];
                foreach ($value['artists'] as $val) {
                    if (!isset($temp['artist'])) {
                        $temp['artist'] = $val['name'];
                    } else {
                        $temp['artist'] = $temp['artist'] . "," . $val['name'];
                    }
                }
                if ($value['album']['cover'] != "") {
                    $temp['cover'] = $value['album']['cover'];
                } else {
                    $temp['cover'] = 'http://ww1.sinaimg.cn/large/005BYqpggy1g2e5iq3k63j308c08cdfo.jpg';
                }
                $temp['lrc'] = SITE_URL . 'lrc/get/type/xiami/mid/' . $value['id'];
                $temp['url_128'] = $value['file'];
                $temp['url'] = $temp['url_128'];
                array_push($List['list'], $temp);
                unset($temp);
            }
            if ($Data['total'] / ($page * 20) > 1) {
                $List['more'] = '1';
            } else {
                $List['more'] = '0';
            }
        }
        return $List;
    }
}