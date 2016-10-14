<?PHP
abstract class Control {

	public static function handle ($db, $view) {
		if (ft_array_key_exists($_POST, 'connection')) {
			self::_connection($db, $view);
		}
		else if (isset($_POST) && isset($_SESSION['login']))
			self::_post($db, $view, $_POST);
		if (isset($_GET))
			self::_get($db, $view, $_GET);
		if ($view->page == 'admin' || $view->page == 'galerie')
			$view->set_galery($db->get_category());
		echo $view;
	}
/*
	private static function _connection ($db, $view) {
		if ($_POST['connection'] === 'connect') {
			if ($db->connect($_POST['login'], $_POST['password']))
				$view->set_notify('green', 'connection granted');
			else
				$view->set_notify('red', 'connection failed');
		}
		else if ($_POST['connection'] === 'disconnect') {
			$db->disconnect();
			$view->set_notify('green', 'disconnected');
		}
		else if ($_POST['connection'] === 'passwd') {
			if ($db->passwd($_POST['login'], $_POST['password'], $_POST['newpasswd']))
				$view->set_notify('green', 'passwd changed');
			else
				$view->set_notify('red', 'passwd unchanged');
		}
	}
 */
	private static function _get ($db, $view, $get) {
		if (isset($_GET['page'])) {
			if ($_GET['page'] == 'admin' && !isset($_SESSION['login'])
				&& !$db->connect($_SERVER[PHP_AUTH_USER], $_SERVER[PHP_AUTH_PW])) {
					header("WWW-Authenticate: Basic realm=''Espace membres''");
					header('HTTP/1.0 401 Unauthorized');
					header("Connection: close", true);
					echo "<html><body>Cette zone est accessible uniquement aux adminnistrateurs du site</body></html>";
				}
			else if ($_GET['page'] == 'deco') {
				$db->disconnect();
				$_GET['page'] = NULL;
			}
			$view->page = $_GET['page'];
			if ($_GET['page'] == 'accueil')
				unset($view->page);
		}
	}

	private static function _post ($db, $view, $get) {
		if (ft_array_key_exists($_POST, 'newcategory'))
			$db->add_category($_POST['newcategory']);
		if (ft_array_key_exists($_POST, 'delcategory'))
			$db->del_category($_POST['delcategory']);
	}
}
?>
