<?php

require_once('../../config/icalLogin.php');

$tmpGet = $_GET;

try {
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$conn = new PDO($dbDriver . ':host=' . $dbHost . ';dbname=' . $db . ';charset=ascii', $dbUser, $dbPass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = $conn->prepare('SELECT url_fragment FROM shortLinks WHERE id=:id');
		$query->bindValue('id', $_GET['id']);
		if ($query->execute()) {
			$rows = $query->fetchAll(PDO::FETCH_ASSOC);
			if (count($rows) > 0) {
				foreach ($_GET as $key => $value) {
					$_GET[$key] = NULL;
					unset($_GET[$key]);
				}
				$frag = $rows[0]['url_fragment'];
				$parts = explode('&',$frag);
				foreach ($parts as $part) {
					$p = explode('=', $part);
					$p1 = $p[0];
					$p2 = '';
					if (count($p)>1)
						$p2 = urldecode(implode('=', array_slice($p, 1)));
					$_GET[$p1] = $p2;
				}
			}
		}
	}
}
catch (PDOException $e) {
	$_GET = $tmpGet;
}

//parse ical file
require_once('ical.php');
if (!isset($_GET['ical_link'])) {
	die('');
}

$amount = 1;
while (isset($_GET['ical_link'.($amount+1)])) $amount++;

$link = array();
$ical = array();
$c = array();
$checkSummary = array();
$checkDescription = array();
$regex = array();
$checkSummaryNot = array();
$checkDescriptionNot = array();
$regexNot = array();

$link[1] = $_GET['ical_link'];
$checkSummary[1] = isset($_GET['summary']);
$checkDescription[1] = isset($_GET['description']);
$regex[1] = '.';
if (isset($_GET['regex'])) {
	$regex[1] = $_GET['regex'];
}
$checkSummaryNot[1] = isset($_GET['summary_not']);
$checkDescriptionNot[1] = isset($_GET['description_not']);
$regexNot[1] = '.';
if (isset($_GET['regex_not'])) {
	$regexNot[1] = $_GET['regex_not'];
}

for ($i = 2; $i <= $amount; $i++) {
	$link[$i] = $_GET['ical_link'.$i];
	$checkSummary[$i] = isset($_GET['summary'.$i]);
	$checkDescription[$i] = isset($_GET['description'.$i]);
	$regex[$i] = '.';
	if (isset($_GET['regex'.$i])) {
		$regex[$i] = $_GET['regex'.$i];
	}
	$checkSummaryNot[$i] = isset($_GET['summary_not'.$i]);
	$checkDescriptionNot[$i] = isset($_GET['description_not'.$i]);
	$regexNot[$i] = '.';
	if (isset($_GET['regex_not'.$i])) {
		$regexNot[$i] = $_GET['regex_not'.$i];
	}
}

$final = null;

for ($i = 1; $i <= $amount; $i++) {
	if (filter_var($link[$i], FILTER_VALIDATE_URL)) {
		$ical[$i] = file_get_contents($link[$i]);
		$c[$i] = parseIcal($ical[$i]);
		if (isset($c[$i]) && !is_null($c[$i]) && $c[$i] != null) {
			$c[$i]->filter($regex[$i],$checkSummary[$i],$checkDescription[$i],$regexNot[$i],$checkSummaryNot[$i],$checkDescriptionNot[$i]);
			if ($final == null)
				$final = $c[$i];
			else
				$final = mergeIcal($final, $c[$i]);
		}
	}
}

if ($final != null) {
	if (isset($_GET['name']) && $_GET['name'] !== NULL && $_GET['name'] !== '') {
		$final->setName($_GET['name']);
	}
	if (isset($_GET['desc']) && $_GET['desc'] !== NULL && $_GET['desc'] !== '') {
		$final->setDescription($_GET['desc']);
	}
	if (isset($_GET['ttl']) && $_GET['ttl'] !== NULL && $_GET['ttl'] !== '' && is_numeric($_GET['ttl']) && intval($_GET['ttl']) > 0) {
		$final->setTtl('PT' . intval($_GET['ttl']) . 'H');
	}
	echo $final->toString();
}
?>