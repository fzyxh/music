<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<?php
class api {
    public function SearchList($Text, $Page) {
        $Data = curl_request('https://my-free-mp3s.com/api/search.php?callback=jQuery2130753441720219949_1551201410793', array('q' => urldecode($Text), 'page' => ($Page - 1)), array('X-Requested-With:XMLHttpRequest', 'Referer:https://my-free-mp3s.com/mp3juices'));
        $Data = jsonp_decode($Data, true);
        $Data = $Data['response'];
        $List = ['list' => []];
        function encode($input) {
            $Map = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'x', 'y', 'z', '1', '2', '3'];
            $length = count($Map);
            $encoded = "";
            if ($input === 0) {
                return $Map[0];
            }
            if ($input < 0) {
                $input *= -1;
                $encoded .= "-";
            }
            while ($input > 0) {
                $val = floor($input % $length);
                $input = floor($input / $length);
                $encoded .= $Map[$val];
            }
            return $encoded;
        }
        if (f_count($Data) != 0) {
            foreach ($Data as $key => $value) {
                if (is_array($value) === false) {
                    continue;
                }
                $temp['name'] = $value['title'];
                $temp['artist'] = $value['artist'];
                $temp['lrc'] = SITE_URL . 'lrc/get/type/myfreemp3/mid/' . $value['id'];
                $temp['cover'] = 'http://ww1.sinaimg.cn/large/005BYqpggy1g2e5iq3k63j308c08cdfo.jpg';
                if ($value['is_hq'] === true) {
                    $temp['url_320'] = 'https://sendto.club/' . encode($value['owner_id']) . ':' . encode($value['id']);
                    $temp['url'] = $temp['url_320'];
                } else {
                    $temp['url_128'] = 'https://sendto.club/' . encode($value['owner_id']) . ':' . encode($value['id']);
                    $temp['url'] = $temp['url_128'];
                }
                array_push($List['list'], $temp);
                unset($temp);
            }
        }
        $List['more'] = '1';
        return $List;
    }
}