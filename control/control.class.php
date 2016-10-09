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
	}

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

	private static function _get ($db, $view, $get) {
	}

	private static function _post ($db, $view, $get) {
	}
}
?>
