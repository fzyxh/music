<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<?php
class api {
    public function SearchList($text, $page) {
        $Data = curl_request('http://music.163.com/api/cloudsearch/pc?s=' . $text . '&type=1&limit=20&offset=' . (($page - 1) * 20));
        $Data = json_decode($Data, true);
        $ListData = $Data['result']['songs'];
        $List = ['list' => []];
        if (f_count($Data['result']['songs']) > 0) {
            $ids = '[';
            foreach ($ListData as $key => $value) {
                $temp['name'] = $value['name'];
                foreach ($value['ar'] as $val) {
                    if (!isset($temp['artist'])) {
                        $temp['artist'] = $val['name'];
                    } else {
                        $temp['artist'] = $temp['artist'] . "," . $val['name'];
                    }
                }
                if ($value['al']['picUrl']) {
                    $temp['cover'] = $value['al']['picUrl'];
                } else {
                    $temp['cover'] = 'http://ww1.sinaimg.cn/large/005BYqpggy1g2e5iq3k63j308c08cdfo.jpg';
                }
                $temp['lrc'] = SITE_URL . 'lrc/get/type/netease/mid/' . $value['id'];
                $ids .= $value['id'] . ',';
                // array_push($ids, $value['id']);
                $temp['url_128'] = 'https://api.fczbl.vip/163/?type=url&id=' . $value['id'];
                // $temp['url_128'] = 'https://api.imjad.cn/cloudmusic/?type=song&br=320000&raw=true&id=' . $value['id'];
                $temp['url'] = $temp['url_128'];
                array_push($List['list'], $temp);
                unset($temp);
            }
            $ids = substr($ids, 0, -1);
            $ids .= ']';
            $Data2 = curl_request('http://music.163.com/api/song/enhance/player/url?ids=' . $ids . '&br=999000');
            $Data2 = json_decode($Data2, true);
            $ListData2 = $Data2['data'];
            foreach ($ListData2 as $key => $value) {
                if ($value['url']) {
                    $List['list'][$key]['url_128'] = $value['url'];
                    $List['list'][$key]['url'] = $value['url'];
                }

            }
            if ($Data['result']['songCount'] / ($page * 20) > 1) {
                $List['more'] = '1';
            } else {
                $List['more'] = '0';
            }
        }
        return $List;
    }
    public function SearchPlaylist($id) {
        $Data = curl_request('http://music.163.com/api/playlist/detail?id=' . $id);
        $Data = json_decode($Data, true);
        $ListData = $Data['result']['tracks'];
        $List = ['list' => []];
        if (f_count($Data['result']['tracks']) > 0) {
            foreach ($ListData as $value) {
                $temp['name'] = $value['name'];
                foreach ($value['artists'] as $v) {
                    if (!isset($temp['artist'])) {
                        $temp['artist'] = $v['name'];
                    } else {
                        $temp['artist'] = $temp['artist'] . "," . $v['name'];
                    }
                }
                $temp['cover'] = $value['album']['picUrl'];
                $temp['lrc'] = SITE_URL . 'lrc/get/type/netease/mid/' . $value['id'];
                $temp['url_128'] = 'https://api.fczbl.vip/163/?type=url&id=' . $value['id'];
                // $temp['url_128'] = 'https://api.imjad.cn/cloudmusic/?type=song&br=320000&raw=true&id=' . $value['id'];
                $temp['url'] = $temp['url_128'];
                array_push($List['list'], $temp);
                unset($temp);
            }
        }
        return $List;
    }
    public function SearchSong($id) {
        $Data = curl_request('http://music.163.com/api/song/detail?id=' . $id . '&ids=[' . $id . ']');
        $Data = json_decode($Data, true);
        if ($Data['code'] !== 200) {
            response('', 400, $Data['msg']);
            exit();
        }
        if (f_count($Data['songs']) > 0) {
            $Data = $Data['songs'][0];
            $List = ['list' => []];
            if (f_count($Data) != 0) {
                $temp['name'] = $Data['name'];
                foreach ($Data['artists'] as $val) {
                    if (!isset($temp['artist'])) {
                        $temp['artist'] = $val['name'];
                    } else {
                        $temp['artist'] = $temp['artist'] . "," . $val['name'];
                    }
                }
                $temp['cover'] = $Data['album']['picUrl'];
                $temp['lrc'] = SITE_URL . 'lrc/get/type/netease/mid/' . $id;
                $temp['url_128'] = 'https://api.fczbl.vip/163/?type=url&id=' . $Data['id'];
                // $temp['url_128'] = 'https://api.imjad.cn/cloudmusic/?type=song&br=320000&raw=true&id=' . $Data['id'];
                $temp['url'] = $temp['url_128'];
                array_push($List['list'], $temp);
                unset($temp);
            }
            return $List;
        }
    }
}