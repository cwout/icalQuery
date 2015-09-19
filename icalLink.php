<?php

try {
	require_once('../../config/icalLogin.php');

	try {
		if (isset($_POST['fragment']) && $_POST['fragment'] != '') {
			$conn = new PDO($dbDriver . ':host=' . $dbHost . ';dbname=' . $db . ';charset=ascii', $dbUser, $dbPass);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = $conn->prepare('INSERT INTO shortLinks (url_fragment,last_requested) VALUES (:frag,:dt)');
			$query->bindValue('frag', $_POST['fragment']);
			$dt = date('Y-m-d H:i:s', time());
			$query->bindValue('dt', $dt);
			if ($query->execute()) {
				$id = $conn->lastInsertId('id');
				if ($id > 0) {
					echo 'http://thefaceless.be/icalQuery/' . $id . '.ics';
				}
			}
		}
	}
	catch (PDOException $e) {}
}
catch (Exeption $e) {}

?>