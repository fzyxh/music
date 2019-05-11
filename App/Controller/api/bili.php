<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<?php
require CORE_PATH . 'mcrypt.php';
class api {
    public function SearchList($text, $page) {
        $Data = curl_request('https://api.bilibili.com/audio/music-service-c/s?keyword=' . $text . '&page=' . $page . '&pagesize=20&search_type=music');
        $Data = json_decode($Data, true);
        $ListData = $Data['data']['result'];
        $List = ['list' => []];
        if (count($ListData) != 0) {
            foreach ($ListData as $key => $value) {
                $temp['name'] = html_entity_decode($value['title'],ENT_QUOTES);
                if ($value['writer'] !== "") {
                    $temp['artist'] = html_entity_decode($value['writer'],ENT_QUOTES);
                } else {
                    $temp['artist'] = html_entity_decode($value['author'],ENT_QUOTES);
                }
                $temp['cover'] = $value['cover'];
                $noUrl = true;
                foreach ($value['play_url_list'] as $val) {
                    if (strpos($val['url'], '/null?') !== true) {
                        if (strpos($val['url'], 'flac.flac?') !== false) {
                            $temp['url_flac'] = $val['url'];
                            $noUrl = false;
                        }
                        if (strpos($val['url'], '320k.m4a?') !== false) {
                            $temp['url_320'] = $val['url'];
                            $noUrl = false;
                        }
                        if (strpos($val['url'], '192k.m4a?') !== false) {
                            $temp['url_128'] = $val['url'];
                            $noUrl = false;
                        }
                    }
                }
                if (isset($temp['url_128'])) {
                    $temp['url'] = $temp['url_128'];
                } elseif (isset($temp['url_320'])) {
                    $temp['url'] = $temp['url_320'];
                } elseif (isset($temp['url_flac'])) {
                    $temp['url'] = $temp['url_flac'];
                }
                if ($noUrl) {
                    $temp['url_320'] = SITE_URL . 'dl/bili/id/' . $value['id'] . '/format/320/token/' . Mcrypt::encode($value['id'], '2610382');
                    $temp['url'] = $temp['url_320'];
                }
                $temp['lrc'] = SITE_URL . 'lrc/get/type/bili/mid/' . $value['id'];
                array_push($List['list'], $temp);
                unset($temp);
            }
            if ($Data['data']['num_pages'] / $page > 1) {
                $List['more'] = '1';
            } else {
                $List['more'] = '0';
            }
        }
        return $List;
    }
}
