<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<?php
class ajax {
    public function search($param) {
        if (isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'], 'POST')) {
            
        } else {
            exit();
        }
        $Token = $param['token'];
        $Text = $param['text'];
        $Page = $param['page'];
        $Type = $param['type'];
        if ($Token !== md5('text/' . $Text . '/page/' . $Page . '/type/' . $Type . '<WC7X5YZxq')) {
            send_http_status(403, TRUE);
            exit();
        }
        $Text = base64_decode(str_replace('*', '/', $param['text']));
        $List = [];
        if (preg_match('/y\.qq\.com\/(n|v8)\//', $Text)) {
            preg_match('/y\.qq\.com\/n\/yqq\/song\/([a-zA-Z0-9]+)(_num|).html/i', $Text, $match_Song);
            preg_match('/y\.qq\.com\/v8\/playsong.html?(.*?)songmid=([a-zA-Z0-9]+)/i', $Text, $match_Song_Wap);
            preg_match('/y\.qq\.com\/n\/yqq\/album\/([a-zA-Z0-9]+)(_num|).html/i', $Text, $match_Album);
            preg_match('/y\.qq\.com\/n\/m\/detail\/album\/index\.html?(.*?)[albumid|albummid]=([a-zA-Z0-9]+)/i', $Text, $match_Album_Wap);
            preg_match('/y\.qq\.com\/n\/yqq\/playsquare\/([a-zA-Z0-9]+).html/i', $Text, $match_Playsquare);
            preg_match('/y\.qq\.com\/n\/yqq\/playlist\/([a-zA-Z0-9]+).html/i', $Text, $match_Playlist);
            preg_match('/y\.qq\.com\/n\/m\/detail\/taoge\/index\.html?(.*?)id=([a-zA-Z0-9]+)/i', $Text, $match_Playlist_Wap);
            preg_match('/y\.qq\.com\/n\/yqq\/singer\/([a-zA-Z0-9]+)(_num|).html/i', $Text, $match_Singer);
            preg_match('/y\.qq\.com\/n\/m\/detail\/singer\/index\.html?(.*?)singerMid=([a-zA-Z0-9]+)/i', $Text, $match_Singer_Wap);
            preg_match('/y\.qq\.com\/n\/yqq\/toplist\/([a-zA-Z0-9]+).html/i', $Text, $match_Toplist);
            preg_match('/y\.qq\.com\/n\/m\/detail\/toplist\/index\.html?(.*?)id=([a-zA-Z0-9]+)/i', $Text, $match_Toplist_Wap);
            require MODULE_DIR . "api/qq.php";
            $api = new api;
            if (!empty($match_Song)) {
                $id = $match_Song[1];
                if (is_numeric($id)) {
                    $List = $api->SearchSong($id, 1); //ID
                } else {
                    $List = $api->SearchSong($id, 2); //MID
                }
            } elseif (!empty($match_Song_Wap)) {
                $id = $match_Song_Wap[2];
                $List = $api->SearchSong($id, 2); //MID
            } elseif (!empty($match_Album)) {
                $id = $match_Album[1];
                if (is_numeric($id)) {
                    $List = $api->SearchAlbum($id, 1, $Page); //ID
                } else {
                    $List = $api->SearchAlbum($id, 2, $Page); //MID
                }
            } elseif (!empty($match_Album_Wap)) {
                $id = $match_Album_Wap[2];
                if (is_numeric($id)) {
                    $List = $api->SearchAlbum($id, 1, $Page); //ID
                } else {
                    $List = $api->SearchAlbum($id, 2, $Page); //MID
                }
            } elseif (!empty($match_Playsquare)) {
                $id = $match_Playsquare[1];
                $List = $api->SearchPlaylist($id);
            } elseif (!empty($match_Singer)) {
                $id = $match_Singer[1];
                if (is_numeric($id)) {
                    $List = $api->SearchSinger($id, 1, $Page); //ID
                } else {
                    $List = $api->SearchSinger($id, 2, $Page); //MID
                }
            } elseif (!empty($match_Singer_Wap)) {
                $id = $match_Singer_Wap[2];
                if (is_numeric($id)) {
                    $List = $api->SearchSinger($id, 1, $Page); //ID
                } else {
                    $List = $api->SearchSinger($id, 2, $Page); //MID
                }
            } elseif (!empty($match_Toplist)) {
                $id = $match_Toplist[1];
                $List = $api->SearchToplist($id, $Page);
            } elseif (!empty($match_Toplist_Wap)) {
                $id = $match_Toplist_Wap[2];
                $List = $api->SearchToplist($id, $Page);
            } elseif (!empty($match_Playlist)) {
                $id = $match_Playlist[1];
                $List = $api->SearchPlaylist($id);
            } elseif (!empty($match_Playlist_Wap)) {
                $id = $match_Playlist_Wap[2];
                $List = $api->SearchPlaylist($id);
            }
        } elseif (preg_match('/music\.163\.com\/(#\/|)(song|m|playlist)/i', $Text)) {
            preg_match('/music\.163\.com\/(#\/|)song(\?id=|\/)([0-9]+)/i', $Text, $match_Netease_Song);
            preg_match('/music\.163\.com\/(#\/|)(m\/|)playlist(\?id=|\/)([0-9]+)/i', $Text, $match_Netease_Playlist);
            require MODULE_DIR . "api/netease.php";
            $api = new api;
            if (!empty($match_Netease_Song)) {
                $id = $match_Netease_Song[3];
                $List = $api->SearchSong($id);
            } elseif (!empty($match_Netease_Playlist)) {
                $id = $match_Netease_Playlist[4];
                $List = $api->SearchPlaylist($id);
            }
        } elseif (preg_match('/node\.kg\.qq\.com\/(play|share\.html)\?s=([a-zA-Z0-9_]+)/i', $Text, $match_Qmkg_Song)) {
            require MODULE_DIR . "api/kg.php";
            $api = new api;
            if (!empty($match_Qmkg_Song)) {
                $id = $match_Qmkg_Song[2];
                $List = $api->SearchSong($id);
            }
        } else {
            $Text = urlencode($Text);
            if ($Type === 'qq') {
                require MODULE_DIR . "api/" . $Type . ".php";
                $api = new api;
                $List = $api->SearchList($Text, $Page);
            } elseif ($Type === 'netease') {
                require MODULE_DIR . "api/" . $Type . ".php";
                $api = new api;
                $List = $api->SearchList($Text, $Page);
            } elseif ($Type === 'xiami') {
                require MODULE_DIR . "api/" . $Type . ".php";
                $api = new api;
                $List = $api->SearchList($Text, $Page);
            } elseif ($Type === 'kuwo') {
                require MODULE_DIR . "api/" . $Type . ".php";
                $api = new api;
                $List = $api->SearchList($Text, $Page);
            } elseif ($Type === 'kugou') {
                require MODULE_DIR . "api/" . $Type . ".php";
                $api = new api;
                $List = $api->SearchList($Text, $Page);
            } elseif ($Type === 'bili') {
                require MODULE_DIR . "api/" . $Type . ".php";
                $api = new api;
                $List = $api->SearchList($Text, $Page);
            } elseif ($Type === 'qingting' || $Type === 'ximalaya' || $Type === '5singyc' || $Type === '5singfc') {
                require MODULE_DIR . "api/other.php";
                $api = new api;
                $List = $api->SearchList('http://www.jbsou.cn/', $Text, $Page, $Type);
            } elseif ($Type === 'baidu' || $Type === '1ting' || $Type === 'migu' || $Type === 'lizhi' || $Type === 'kg') {
                require MODULE_DIR . "api/other.php";
                $api = new api;
                $List = $api->SearchList('http://www.jbsou.cn/', $Text, $Page, $Type);
            } elseif ($Type === 'myfreemp3') {
                require MODULE_DIR . "api/" . $Type . ".php";
                $api = new api;
                $List = $api->SearchList($Text, $Page);
            } else {
                require MODULE_DIR . "api/" . $Type . ".php";
                $api = new api;
                $List = $api->SearchList($Text, $Page);
            }
        }
        response($List, 200, '');
        logResult('search ' . urldecode($Text));
        exit();
    }
}
