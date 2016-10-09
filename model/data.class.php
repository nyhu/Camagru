<?PHP
class Data {
	private static $v = 0;
	private $base;

	public function __construct () {
		$base = "pierreduplouy";
		$this->base = mysqli_connect($_SERVER['REMOTE_HOST'], "root", "", $base);
		if (mysqli_connect_errno($this->base)) {
			die(mysqli_connect_error());
		}
		if (self::$v)
			echo "object construct".PHP_EOL;
	}

	public function __destruct () {
		mysqli_close($this->base);
		if ($this->v)
			echo "object destruct".PHP_EOL;
	}

	public static function verbose () {
		self::$v ^= 1;
		echo "verbose set to ".self::$v.PHP_EOL;
	}

	public function connect ($login, $passwd) {
		$passwd = $this->_pwd_hash($passwd);
		$login = $this->_secure($login);
		if (self::$v)
			echo "login = '".$login."' password = '".$passwd."'".PHP_EOL;
		if (($result = $this->_query("SELECT password, access FROM user WHERE login='".$login."';"))
			&& $result->num_rows !== 0) {
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					if (self::$v) {
						echo "user pwd in db = ";
						print_r($row);
					}
					if ($row['password'] === $passwd) {
						$_SESSION['login'] = $login;
						$_SESSION['access'] = $row['access'];
						if (self::$v)
							echo "connection granted".PHP_EOL;
						return true;
					}
				}
			}
		if (self::$v)
			echo "connection denied".PHP_EOL;
		return false;
	}

	public function disconnect () {
		unset($_SESSION['login']);
		unset($_SESSION['right']);
	}

	public function passwd ($login, $old, $new) {
		if ($this->connect($login, $old)
			&& $this->_query("UPDATE user
			SET password = '".$this->_pwd_hash($new)."'
			WHERE login = '".$this->_secure($login)."';"))
			return true;
		return false;
	}

	private function _query ($query) {
		return (mysqli_query($this->base, $query));
	}

	private function _pwd_hash ($passwd) {
		return (hash('whirlpool', $this->_secure($passwd)));
	}

	private function _secure ($string) {
		if (ctype_digit($string)) {
			$string = intval($string);
		}
		else {
			$string = mysqli_real_escape_string($this->base, $string);
			$string = addcslashes($string, '%_');
		}
		return $string;
	}
}
?>
