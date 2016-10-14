<?PHP
include_once('./model/data.class.php');
include_once('./view/view.class.php');
include_once('./control/control.class.php');

function ft_array_key_exists($array, $key) {
	if (isset($array[$key]) && !empty($array[$key]))
		return true;
	return false;
}

session_start();
$db = new Data;
$view = new View;
Control::handle($db, $view);
unset($db);
unset($view);
exit;
?>
