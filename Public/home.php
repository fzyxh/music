<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include 'head.php';?>
	<title>免费音乐</title>
	<meta name="keywords" content="免费音乐">
	<meta name="description" content="欢迎大家收藏本站，并将它介绍给你的朋友！">
	<link rel="stylesheet" href="<?php echo SITE_URL; ?>Public/css/main.css?v=<?php echo APP_VERSION; ?>">
	<meta name="referrer" content="never">
</head>
<body>
	<div id="loader"><div id="loader-content"></div><div id="loader-text">正在渲染页面<br>长时间停留此页面请刷新网页</div></div>
	<div class="header">
		<div class="am-container">
			<a id="title">免费音乐</a>
			<div class="am-fr" id="menu-group">
				<div class="am-dropdown" data-am-dropdown>
					<a class="am-dropdown-toggle"><i class="am-icon-ellipsis-v"></i>菜单</a>
					<ul class="am-dropdown-content">
						<li class="am-dropdown-header">o(〃'▽'〃)o</li>
						<li><a data-am-modal="{target: '#configure'}"><i class="am-icon-cog"></i> 设置</a></li>
						<li><a data-am-modal="{target: '#trophy'}"><i class="am-icon-trophy"></i> 排行榜</a></li>
						<li><a href="question.php#q1" target="_blank"><i class="am-icon-info"></i> 解析列表</a></li>
						<li><a href="question.php#q2" target="_blank"><i class="am-icon-question"></i> 常见问题</a></li>
						<li><a data-am-modal="{target: '#fenxiang'}"><i class="am-icon-share-alt"></i> 分享</a></li>
						<li><a data-am-modal="{target: '#zanzhu'}"><i class="am-icon-jpy"></i> 赞助</a></li>
					</ul>
				</div>
			</div>
			<div class="am-fr" id="fast-download">
				<a data-br="m4a">M4A</a>
				<a data-br="128">128K</a>
				<a data-br="320">320K</a>
				<a data-br="flac">FLAC</a>
				<a data-br="ape">APE</a>
				<a id="download"></a>
			</div>
		</div>
	</div>
	<div class="am-container" id="main">
		<form id="search">
			<div class="am-input-group am-input-group-secondary">
				<select data-am-selected id="type">
					<!-- <option value="qq">腾讯</option> -->
					<option value="kuwo">酷我</option>
					<option value="kugou">酷狗</option>
					<option value="myfreemp3">MyFreeMp3</option>
					<option value="netease">网易云</option>
					<option value="xiami">虾米</option>
					<option value="baidu">百度</option>
					<!-- <option value="1ting">一听</option> -->
					<!-- <option value="migu">咪咕</option> -->
					<!-- <option value="lizhi">荔枝</option> -->
					<!-- <option value="qingting">蜻蜓</option> -->
					<option value="ximalaya">喜马拉雅</option>
					<!-- <option value="kg">全民K歌</option> -->
					<!-- <option value="5singyc">5sing原创</option> -->
					<!-- <option value="5singfc">5sing翻唱</option> -->
				</select>
				<input type="text" autocomplete="off" class="am-form-field am-field-valid" id="input" placeholder="歌名 - 歌手 或 链接" pattern="^.+$" required>
				<span class="am-input-group-btn" data-am-dropdown="">
					<button class="am-btn am-btn-secondary" id="empty" type="button"><span class="am-icon-remove"></span></button>
					<button class="am-btn am-btn-secondary" type="submit"><span class="am-icon-search"></span></button>
				</span>
			</div>
			<div class="smartbox">
				<a id="close">关闭</a>
				<a class="smartbox_group">
					单曲
				</a>
				<a class="smartbox_group">
					歌手
				</a>
			</div>
		</form>
		<div id="homePage" class="row">
			<div class="am-g">
				<div class="home-title">公告</div>
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<div id="home-ads"></div>
				<div id="msg" style="color: red;">请手动按Ctrl+F5刷新网页</div>
				<div class="home-title">歌单推荐<a href="favorite.php"><span>查看我的收藏</span></a></div>

				<div id="recomPlaylist"></div>
				<div class="home-title">热门搜索</div>
				<div id="hotkey" class="key-group"></div>
			</div>
		</div>
		<div id="audioPage" class="row">
			<div id="player" class="aplayer"></div>
		</div>
		<div id="downloadPage" class="row">
			<div class="am-g">
				<a href="" target="_blank" id="download-complete"></a>
				<div class="am-u-lg">
					链接仅提供下载服务，请勿用作外链。<br>
					安卓端用户请使用360极速浏览器。<br>
					PC端用户请使用Chrome或QQ浏览器。<br>
					下载速度取决于你的网速和配置。<br>
					Ctrl+D可收藏本网站。
				</div>
			</div>
		</div>
		<div id="floatbtn">
			<button class="am-btn am-round" id="go-top"><i class="am-icon-arrow-up"></i>回到顶部</button>
			<button class="am-btn am-round" id="zipdownload"><i class="am-icon-download"></i>批量下载</button>
			<a href="https://greasyfork.org/zh-CN/scripts/370308" target="_blank" rel="nofollow"><button class="am-btn am-round"><i class="am-icon-star"></i>油猴脚本</button></a>
			<button class="am-btn am-round" data-am-modal="{target: '#trophy'}"><i class="am-icon-trophy"></i>排行榜</button>
			<button class="am-btn am-round" data-am-modal="{target: '#configure'}"><i class="am-icon-cog"></i>设置</button>
		</div>
	</div>
	<footer>
		<div class="colour-border"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>

		<div class="am-container">
免费音乐下载<br>
❤欢迎使用免费音乐下载<br>
MP3 下载<br>
✅今天，越来越多的互联网用户更喜欢收听BEST 免费在线音乐。不仅可以收听，还可以下载免费mp3格式。最流行的音乐门户网站收集了最多样化的音乐，可以预览并免费下载音乐。在网站上，您不仅可以欣赏喜欢的音乐，还可以下载歌曲而无需注册。如果您愿意，可以在任何方便的时间在线收听您喜爱的歌曲。<br>
Mp3Juices 替代<br>
✅在Mp3 Juices上，音乐下载门户网站的用户可以找到他们喜爱的歌曲类型 - 岩，R＆B和灵魂，流行的，拉丁，爵士乐，嘻哈，民间，电子，乡村，蓝调，亚洲，非洲和很多混音。并且为了下载音乐，您无需经历繁琐的注册过程。资源的版主已经打开了对门户网站用户的所有歌曲的访问权限。只需点击一下 - 手机中已经有所需的旋律。您可以轻松下载久经考验的热门歌曲和“备受瞩目”的新奇事物。<br>
✅让下载音乐的过程尽可能舒适。您可以免费下载mp3作为单独的歌曲并下载任何艺术家的音乐收藏，这当然会节省很多时间。<br>
新中国歌曲<br>
✅门户网站免费音乐是一个巨大的媒体库，当然还有很多 中国歌曲，涵盖不同类型和时间范围的音乐。 您可以在几秒钟内找到免费音乐。 只需在搜索字符串中输入音乐家或集体的名称或创意假名即可。 在下载之前，您可以听到旋律，并确保这是您正在寻找的那个， mp3下载到任何设备。 您只需要使用易于使用的播放器播放我的免费MP3，听歌，下载您喜欢的音乐，并确保它方便快捷<br>
*是最好的音频网站之一，只为您提供 mp3搜索结果。<br>
*所有搜索声音结果几乎都与您的查询匹配。<br>
*我们有世界上最大的 mp3歌曲存档，可以下载。<br>
*玩得开心，享受我们网站的使用！<br>
❤️我们希望您可能会喜欢我们的网站，如果可能的话，请给我们添加书签（CTRL + D）。<br>
为了减轻服务器压力，批量下载中歌词API改为<a href="http://www.bzqll.com/" target="_blank">BZQLL</a>提供的服务器，感谢！<br>
本站本身不储存任何资源文件，资源来自互联网，仅供学习交流试听，禁用于任何商业用途或公开传播的场合，版权归唱片公司所有，请于下载后24小时内删除，支持购买正版专辑！<br>
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
				<h3>自动播放</h3>
				<label class="am-radio-inline">
					<input type="radio" name="autoplay" value="yes" data-am-ucheck>开启
				</label>
				<label class="am-radio-inline">
					<input type="radio" name="autoplay" value="no" data-am-ucheck>关闭
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
</body>
</html>