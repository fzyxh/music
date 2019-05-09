<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<?php
class msg {
    public function get() {
        header('Content-Type:application/json; charset=utf-8');
        // $Referrer = isset($_POST['referrer']) ? $_POST['referrer'] : '';
        // $UA = $_SERVER['HTTP_USER_AGENT'];
        $Msg = [];
        array_push($Msg,['text'=>'<a href="http://tool.liumingye.cn/alipay/index.html" target="_blank">1.每日一次，领支付宝红包</a><br><a href="http://api.liumingye.cn/question.php#download-no-windows" target="_blank" style="color:red">2.下载不显示保存框？下载的歌去哪了？点我查看解决方法</a>']);
        /*if(strstr($Referrer,'www.baidu.com'))
        {
            array_push($Msg,['text'=>'欢迎通过百度搜索访问的你！','style'=>'','time'=>3000]);
        }
        if(strstr($UA,'CoolMarket'))
        {
            array_push($Msg,['text'=>'欢迎通过酷安访问的你！','style'=>'','time'=>3000]);
        }*/
        array_push($Msg,['text'=>'20190505<br>移动端点击下载音乐会自动复制音乐名称和歌手名称，请手动刷新页面清空缓存','style'=>'','time'=>5000]);
        response($Msg, 200, '');
        exit();
    }
}