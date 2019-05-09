<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include '../head.php';?>
	<title>全能VIP在线音乐解析 - 刘明野的工具箱</title>
	<meta name="keywords" content="音乐解析,在线解析,QQ音乐解析,网易云音乐解析,网易云VIP解析,VIP音乐解析,免费下载,付费歌曲,收费歌曲,音乐解析网站,音乐解析下载,全能音乐解析">
	<meta name="description" content="本站为广大网友提供QQ音乐网易云VIP解析服务，让你省去购买音乐VIP费用，欢迎大家收藏本站，并将它介绍给你的朋友！">
	<link rel="stylesheet" href="<?php echo SITE_URL; ?>Public/css/main.css?v=<?php echo APP_VERSION; ?>">
	<meta name="referrer" content="same-origin">
</head>
<body>
	<div id="loader"><div id="loader-content"></div><div id="loader-text">正在渲染页面<br>长时间停留此页面请刷新网页</div></div>
	<div class="header">
		<div class="am-container">
			<a id="title" href="./"></a>
		</div>
	</div>
	<div class="am-container" id="main">
		<div id="homePage" class="row">
			<div class="am-g">
				<div class="home-title">我的收藏</div>
				<div id="favorite"></div>
			</div>
		</div>
	</div>
	<footer>
		<div class="colour-border"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>

		<div class="am-container">
			本站本身不储存任何资源文件，资源来自互联网，仅供学习交流试听，禁用于任何商业用途或公开传播的场合，版权归唱片公司所有，请于下载后24小时内删除，支持购买正版专辑！<br>
			如有侵权，请联系本人予以删除！w9091929@163.com<br>
			© 2015 - 2019 刘明野的工具箱
		</div>
		<!-- 闲聊 -->
		<script>
			var xlm_wid='14361';
			var xlm_url='https://www.xianliao.me/';
		</script>
		<script type='text/javascript' charset='UTF-8' src='https://www.xianliao.me/embed.js'></script>
	</footer>
	<!-- 不显示的元素 -->
	<div class="am-modal" tabindex="-1" id="configure">
		<div class="am-modal-dialog">
			<div class="am-modal-bd">
				<h3>命名规则</h3>
				<label class="am-radio-inline">
					<input type="radio" name="dlname" value="{name} - {singer}" data-am-ucheck>歌名 - 歌手
				</label>
				<label class="am-radio-inline">
					<input type="radio" name="dlname" value="{singer} - {name}" data-am-ucheck>歌手 - 歌名
				</label>
			</div>
			<div class="am-modal-footer">
				<span class="am-modal-btn">完成</span>
			</div>
		</div>
	</div>
	<div class="am-modal" tabindex="-1" id="qrcode">
		<div class="am-modal-dialog">
			<div class="am-modal-hd">扫描二维码下载</div>
			<div class="am-modal-bd"></div>
			<div class="am-modal-footer"> <span class="am-modal-btn">确定</span>
			</div>
		</div>
	</div>
	<div class="am-modal" tabindex="-1" id="batch">
		<div class="am-modal-dialog">
			<div class="am-modal-hd">批量打包下载</div>
			<div class="am-modal-bd"></div>
			<div class="am-modal-footer">
				<span class="am-modal-btn">优先无损下载</span>
				<span class="am-modal-btn">优先高品下载</span>
			</div>
		</div>
	</div>
	<div class="am-modal" tabindex="-1" id="trophy">
		<div class="am-modal-dialog">
			<div class="am-modal-bd"></div>
			<div class="am-modal-footer">
				<span class="am-modal-btn">关闭</span>
			</div>
		</div>
	</div>
	<script src="<?php echo SITE_URL; ?>Public/js/localstorage.js?v=<?php echo APP_VERSION; ?>"></script>
	<script>
        if(Object.keys(favorite).length === 0){
        	$$('#favorite').html('︿(￣︶￣)︿你还没有收藏过歌单~');
        } else {
			var html='<ul>';
			$.each(favorite,function(name,value) {
				html += '<li data-id="' + name + '"><p class="favorite">收藏</p><img src="' + value['img'] + '" onerror="this.src=\'http://ww1.sinaimg.cn/large/005BYqpggy1g2e5iq3k63j308c08cdfo.jpg\';this.onerror=null;"><p class="playlist_title">' + value['title'] + '</p></li>';
			});
	        html += '</ul>';
    		$$('#favorite').html(html);
        }

		$.each($$('#favorite').find('li'), function(i, item) {
			if (favorite[$(item).data('id')] !== undefined) {
			    $(item).find('.favorite').text('取消收藏');
			}
		});
		$$('#favorite').find('li').click(function(e) {
			if ($(e.target).attr('class') === 'favorite') {
			    var dom = $(e.currentTarget);
			    if (e.target.innerText === "收藏") {
	                favorite[dom.data('id')] = {
	                    'img': dom.find('img').attr('src'),
	                    'title': dom.find('.playlist_title').text()
	                };
			        e.target.innerText='取消收藏';
			    }else{
			        delete favorite[dom.data('id')];
			        e.target.innerText='收藏';
			    }
			    cache.set('favorite', favorite);
			    return;
			}
			window.location.href="./?from=favorite&type=qq&name="+encodeURIComponent('https://y.qq.com/n/yqq/playsquare/' + $(e.currentTarget).data('id') + '.html');
		});
	</script>
</body>
</html>