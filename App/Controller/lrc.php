<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<?php
class lrc {
    public function get($param) {
        $Mid = $param['mid'];
        $Type = $param['type'];
        if (!$Mid || !$Type) {
            send_http_status(403, TRUE);
            exit();
        }
        $Download = isset($param['download']) ? $param['download'] : '0';
        $Name = isset($param['name']) ? $param['name'] : $Mid . '.lrc';
        if ($Type === 'qq') {
            $Lrcdata = curl_request('https://c.y.qq.com/lyric/fcgi-bin/fcg_query_lyric_new.fcg?new_json=1&format=json&songmid=' . $Mid);
            $Lrcdata = jsonp_decode($Lrcdata);
            $Lrcdata = base64_decode($Lrcdata['lyric']);
            $Lrcdata = str_replace('[00:00:00]此歌曲为没有填词的纯音乐，请您欣赏', '[00:00.00]此歌曲为没有填词的纯音乐，请您欣赏', $Lrcdata);
        } elseif ($Type === 'netease') {
            $Lrcdata = curl_request('http://music.163.com/api/song/lyric?lv=1&id=' . $Mid);
            $Lrcdata = json_decode($Lrcdata, true);
            $Lrcdata = $Lrcdata['lrc']['lyric'];
        } elseif ($Type === 'kg') {
            $Lrcdata = curl_request('http://kg.qq.com/cgi/fcg_lyric?inCharset=utf8&outCharset=utf-8&format=json&v=4&ksongmid=' . $Mid);
            $Lrcdata = json_decode($Lrcdata, true);
            $Lrcdata = $Lrcdata['data']['lyric'];
        } elseif ($Type === 'kugou') {
            $Lrcdata = curl_request('http://m.kugou.com/app/i/krc.php?cmd=100&timelength=999999&hash=' . $Mid);
        } elseif ($Type === 'kuwo') {
            $Lrcdata = curl_request('https://api.itooi.cn/music/kuwo/lrc?key=579621905&id=' . $Mid);
            /*$Lrcdata = curl_request('http://m.kuwo.cn/newh5/singles/songinfoandlrc?musicId=' . $Mid, null, array('X-FORWARDED-FOR:112.98.92.45','CLIENT-IP:112.98.92.45'));
            $Lrcdata = json_decode($Lrcdata, true);
            $Lrcdata = $Lrcdata['data']['lrclist'];
            if ($Lrcdata) {
                $lrc = '';
                foreach ($Lrcdata as $val) {
                    if ($val['time'] > 60) {
                        $time_exp = explode('.', round($val['time'] / 60, 4));
                        $minute = $time_exp[0] < 10 ? '0' . $time_exp[0] : $time_exp[0];
                        $sec = substr($time_exp[1], 0, 2) . '.' . substr($time_exp[1], 2, 2);
                        $time = '[' . $minute . ':' . $sec . ']';
                    } else {
                        $time = '[00:' . $val['time'] . ']';
                    }
                    $lrc .= $time . $val['lineLyric'] . "\n";
                }
                $Lrcdata = $lrc;
            }*/
        } elseif ($Type === 'xiami') {
            require 'api/meting.php';
            $api = new Meting('xiami');
            $Lrcdata = $api->lyric($Mid);
            $Lrcdata = json_decode($Lrcdata, true);
            if (count($Lrcdata['data']['data']['lyrics'])) {
                $data = $Lrcdata['data']['data']['lyrics'][0]['content'];
                $data = preg_replace('/<[^>]+>/', '', $data);
                preg_match_all('/\[([\d:\.]+)\](.*)\s\[x-trans\](.*)/i', $data, $match);
                if (count($match[0])) {
                    for ($i = 0; $i < count($match[0]); $i++) {
                        $A[] = '[' . $match[1][$i] . ']' . $match[2][$i];
                    }
                    $Lrcdata = str_replace($match[0], $A, $data);
                } else {
                    $Lrcdata = $data;
                }
            } else {
                $Lrcdata = '';
            }
        } elseif ($Type === 'baidu') {
            require 'api/meting.php';
            $api = new Meting('baidu');
            $Lrcdata = $api->lyric($Mid);
            $Lrcdata = json_decode($Lrcdata, true);
            $Lrcdata = $Lrcdata['lrcContent'];
        } elseif ($Type === 'bili') {
            $Data = curl_request('https://www.bilibili.com/audio/music-service-c/web/song/info?sid=' . $Mid);
            $Data = json_decode($Data, true);
            if($Data['data']['lyric']!=""){
                Header('HTTP/1.1 301 Moved Permanently');
                Header('Location:' . $Data['data']['lyric']);
            }else{
                $Lrcdata = '[00:00.00]暂无歌词';
            }
        }
        if ($Download === '1' && $Name) {
            header('Content-type:application/lrc');
            header('Content-Disposition:attachment;filename="' . $Name . '"');
            if ($Lrcdata) {
                echo "[pr:该歌词由刘明野的工具箱(tool.liumingye.cn)提供]\r\n", $Lrcdata;
            } else {
                echo '[00:00.00]暂无歌词';
            }
            logResult('lrc ' . $Name);
        } else {
            header('Content-Type:text/html');
            if ($Lrcdata) {
                if ($Lrcdata === "纯音乐请欣赏") {
                    echo '[00:00.00]此歌曲为没有填词的纯音乐，请您欣赏';
                } else {
                    echo $Lrcdata;
                }
            } else {
                echo '[00:00.00]暂无歌词';
            }
        }
        exit();
    }
}
