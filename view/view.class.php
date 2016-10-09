<?PHP
class View {
	private $notify;

	public function __construct () {
	}

	public function __destruct () {
	}

	public function set_notify ($color, $type) {
		$this->notify = array('color' => $color, 'type' => $type);
	}

	public function get_notify () {
		return ($this->notify);
	}
}
?>
