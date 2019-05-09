<?php if (!defined('APP_NAME')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>
<?php
class favorite {
    public function index() {
		include('Public/favorite.php');
    }
}