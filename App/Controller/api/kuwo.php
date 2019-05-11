<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<?php
require CORE_PATH . 'mcrypt.php';
class api {
    public function SearchList($text, $page) {
        $Data = curl_request('http://search.kuwo.cn/r.s?pn=' . ($page - 1) . '&ft=music&rn=20&all=' . $text . '&newsearch=1&alflac=1&itemset=web_2014&client=kt&cluster=0&vermerge=0&rformat=json&encoding=utf8&show_copyright_off=1&pcmp4=1&ver=mbox&plat=pc&vipver=MUSIC_8.7.7.1.BCS9&devid=77415881');
        $Data = str_replace('\'', '"', $Data);
        $Data = str_replace('&apos;', '\'', $Data);
        $Data = json_decode($Data, true);
        $ListData = $Data['abslist'];
        $List = ['list' => []];
        if (count($ListData) != 0) {
            foreach ($ListData as $key => $value) {
                $value['MP3RID'] = substr($value['MP3RID'], 4);
                $temp['name'] = html_entity_decode($value['SONGNAME'],ENT_QUOTES);
                $temp['artist'] = html_entity_decode($value['ARTIST'],ENT_QUOTES);
                // $temp['cover'] = SITE_URL . 'dl/cover/id/' . $value['MP3RID'] . '/type/kuwo/token/' . Mcrypt::encode($value['MP3RID'], '2610382');
                $temp['cover'] = 'https://api.itooi.cn/music/kuwo/pic?key=579621905&id=' . $value['MP3RID'];
                $f = explode("|", $value['FORMATS']);
                foreach ($f as $f_key) {
                    switch ($f_key) {
                    case 'WMA96':
                        $temp['url_m4a'] = SITE_URL . 'dl/kuwo/id/' . $value['MP3RID'] . '/format/96kwma/token/' . Mcrypt::encode($value['MP3RID'], '2610382');
                        break;
                    case 'MP3128':
                        $temp['url_128'] = SITE_URL . 'dl/kuwo/id/' . $value['MP3RID'] . '/format/128kmp3/token/' . Mcrypt::encode($value['MP3RID'], '2610382');
                        break;
                    case 'MP3H':
                        $temp['url_320'] = SITE_URL . 'dl/kuwo/id/' . $value['MP3RID'] . '/format/320kmp3/token/' . Mcrypt::encode($value['MP3RID'], '2610382');
                        break;
                    case 'ALFLAC':
                        $temp['url_flac'] = SITE_URL . 'dl/kuwo/id/' . $value['MP3RID'] . '/format/2000kflac/token/' . Mcrypt::encode($value['MP3RID'], '2610382');
                        break;
                    }
                }
                $temp['url'] = 'https://api.itooi.cn/music/kuwo/url?key=579621905&id='.$value['MP3RID'].'&br=96';
                $temp['lrc'] = SITE_URL . 'lrc/get/type/kuwo/mid/' . $value['MP3RID'];
                array_push($List['list'], $temp);
                unset($temp);
            }
            if ($Data['TOTAL'] / ($page * 20) > 1) {
                $List['more'] = '1';
            } else {
                $List['more'] = '0';
            }
        }
        return $List;
    }
}
