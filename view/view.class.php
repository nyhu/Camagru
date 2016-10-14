<?PHP
class View {
	public $page;
	public $galery;
	private $_curg;
	private $_notify;

	public function set_notify ($color, $type) {
		$this->_notify = array('color' => $color, 'type' => $type);
	}

	public function set_galery ($row) {
		$this->galery = $row;
	}

	public function __toString () {
		echo '<!DOCTYPE html><html>';
		$this->_head();
		$this->_body();
		return ('</html>');
	}

	private function _head () {
		echo '<head>';
		echo '<meta charset="utf-8" />';
		echo '<link rel="stylesheet" href="./ressource/style.css" />';
		echo '</head>';
	}

	private function _body () {
		echo '<body>';
		$this->_menu();
		$this->_notify();
		$this->_galery();
//		print_r($_GET);
//		print_r($_POST);
		$this->_adm();
		echo '</body>';
	}

	private function _menu () {
		echo '<div class="menu">';
		if (!isset($this->page))
			echo '<a class="mactive"';
		else
			echo '<a class="mitem"';
		echo 'href="./index.php?page=accueil"><h1>Accueil</h1></a>';
		if ($this->page == 'galerie')
			echo '<a class="mactive"';
		else
			echo '<a class="mitem"';
		echo 'href="./index.php?page=galerie"><h1>Galerie</h1></a>';
		if ($this->page == 'about')
			echo '<a class="mactive"';
		else
			echo '<a class="mitem"';
		echo 'href="./index.php?page=about"><h1>About</h1></a>';
		if ($this->page == 'contact')
			echo '<a class="mactive"';
		else
			echo '<a class="mitem"';
		echo 'href="./index.php?page=contact"><h1>Contact</h1></a>';
		if ($_SESSION['login']) {
			if ($this->page == 'admin')
				echo '<a class="mactive"';
			else if ($_SESSION['login'])
				echo '<a class="mitem"';
			echo 'href="./index.php?page=admin"><h1>Admin</h1></a>';
		}
		echo '</div>';
	}

	private function _notify () {
		if (isset($this->_notify)) {
			echo '<div class="notify'.$this->_notify['color'].'">';
			echo $this->_notify['type'].'</div>';
		}
	}

	private function _galery () {
		if ($this->page == 'galerie' || $this->page == 'admin') {
			echo '<div class="gmenu">';
			if (isset($this->galery)) {
				foreach ($this->galery as $l) {
					$n = $l['name'];
					if ((!isset($this->_curg) && $this->curg = 'a')
						|| $this->_curg === $n)
						echo '<div class="gmactive"><a ';
					else
						echo '<div class="gmitem"><a ';
					echo 'href="./index.php?page='.$this->page.'&curg='.$n.'"><h2>'.$n.'</h2></a>';
					if ($this->page == 'admin')
						echo '<form method="post"><button name="delcategory" value="'.$n.'"/>Supprimer</button></form>';
					echo '</div>';
				}
			}
			if ($this->page == 'admin')
				echo '<form method="post"><input type="text" name="newcategory">Ajouter une categorie</form>';
			echo '</div>';
		}
	}

	private function _adm () {
		echo '<footer><div class="menu bottom">';
		if (!isset($_SESSION['login']))
			echo '<a href="./index.php?page=admin"><button>Administration</button></a>';
		if (isset($_SESSION['login'])) {
			echo '<div>'.$_SESSION['login'].'</br>';
			echo '<a href="./index.php?page=deco"><button>Deconnexion</button></a>';
		}
		echo '</footer></div>';
	}
}
?>
