<?PHP
//	print_r(mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM user;")));
function ft_script_authentificate () {
	if (strcmp("admin", $_SERVER[PHP_AUTH_USER])
		|| strcmp("admin_nyhu", $_SERVER[PHP_AUTH_PW]))
	{
		header("WWW-Authenticate: Basic realm=''Espace membres''");
		header('HTTP/1.0 401 Unauthorized');
		header("Connection: close", true);
		echo "<html><body>Cette zone est accessible uniquement aux membres du site</body></html>"."\n";
		return false;
	}
	return true;
}
$db = "pierreduplouy";
$id = "id INT PRIMARY KEY NOT NULL AUTO_INCREMENT";
if (ft_script_authentificate()){
	if ($mysqli = mysqli_connect($_SERVER['REMOTE_HOST'], "root", "")){
		mysqli_query($mysqli, "CREATE DATABASE IF NOT EXISTS $db;");
		mysqli_close($mysqli);
		if ($mysqli = mysqli_connect($_SERVER['REMOTE_HOST'], "root", "", $db)) {
			if (!mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS user($id, login VARCHAR(100), access VARCHAR(10), email VARCHAR(255), password VARCHAR(128));")) {
				echo "table user creation failed".PHP_EOL;
			}
			else if (!mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS category($id, name VARCHAR(100));")) {
				echo "table category creation failed".PHP_EOL;
			}
			else if (!mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS image($id, id_type INT NOT NULL, name VARCHAR(100), image VARCHAR(256), FOREIGN KEY(id_type) REFERENCES category (id));")) {
				echo "table image creation failed".PHP_EOL;
			}
			else{
				$dflpw = hash('whirlpool', 'admin');
				if (!($res = mysqli_query($mysqli, "SELECT login FROM user WHERE login='tboos'"))
					|| ($res->num_rows === 0 && !mysqli_query($mysqli, "INSERT INTO user(login, access, email, password)
					VALUES('tboos', 'admin', 'tboos@student.42.fr','".$dflpw."');"))) {
					echo "creation admin account failed".PHP_EOL;
				}
			}
			mysqli_close($mysqli);
		}
		else {
			echo "connection to database failed".PHP_EOL;
		}
	}
	else {
		echo "connection to sql failed".PHP_EOL;
	}
}
?>
