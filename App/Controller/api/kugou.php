<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<?php
require CORE_PATH . 'mcrypt.php';
class api {
    public function SearchList($text, $page) {
        $Data = curl_request('http://songsearch.kugou.com/song_search_v2?keyword=' . $text . '&page=' . $page . '&pagesize=20&platform=WebFilter&filter=2&iscorrection=1&privilege_filter=0',null,array('X-FORWARDED-FOR:110.98.92.45'));
        $Data = json_decode($Data, true);
        $ListData = $Data['data']['lists'];
        $List = ['list' => []];
        if (count($ListData) != 0) {
            foreach ($ListData as $key => $value) {
                $temp['name'] = $value['SongName'];
                $temp['artist'] = $value['SingerName'];
                $temp['cover'] = 'https://api.itooi.cn/music/kugou/pic?key=579621905&id=' . $value['FileHash'];
                if ($value['SQFileHash'] !== "00000000000000000000000000000000" && $value['SQFileHash'] !== "") {
                    $temp['url_flac'] = SITE_URL . 'dl/kugou/id/' . $value['SQFileHash'] . '/token/' . Mcrypt::encode($value['SQFileHash'], '123456');
                    $temp['url'] = $temp['url_flac'];
                }
                if ($value['HQFileHash'] !== "00000000000000000000000000000000" && $value['HQFileHash'] !== "") {
                    $temp['url_320'] = SITE_URL . 'dl/kugou/id/' . $value['HQFileHash'] . '/format/320/token/' . Mcrypt::encode($value['HQFileHash'], '123456');
                    $temp['url'] = $temp['url_320'];
                }
                if ($value['FileHash'] !== "00000000000000000000000000000000" && $value['FileHash'] !== "") {
                    $temp['url_128'] = SITE_URL . 'dl/kugou/id/' . $value['FileHash'] . '/format/320/token/' . Mcrypt::encode($value['FileHash'], '123456');
                    $temp['url'] = $temp['url_128'];
                }
                $temp['lrc'] = SITE_URL . 'lrc/get/type/kugou/mid/' . $value['FileHash'];
                array_push($List['list'], $temp);
                unset($temp);
            }
            if ($Data['data']['total'] / ($page * 20) > 1) {
                $List['more'] = '1';
            } else {
                $List['more'] = '0';
            }
        }
        return $List;
    }
}