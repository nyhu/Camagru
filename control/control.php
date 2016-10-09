<?PHP
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
?>
