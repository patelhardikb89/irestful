<?php
function test() {

	if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
		die('Authorization -> '.$_SERVER['HTTP_AUTHORIZATION']);
	}

	if (empty($_GET) && empty($_POST) && empty($_FILES)) {
		die("no params");
	}

	if (!empty($_GET) && empty($_POST) && empty($_FILES)) {
		die(json_encode($_GET));
	}

	if (empty($_GET) && !empty($_POST) && empty($_FILES)) {

		foreach($_POST as $keyname => $value) {

			if (empty($value)) {
				$_POST[$keyname] = null;
			}

		}

		die(json_encode($_POST));
	}

	if (empty($_GET) && empty($_POST) && !empty($_FILES)) {
		die('file size -> '.$_FILES['file']['size']);
	}


}

test();
