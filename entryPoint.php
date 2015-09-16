<?php
require_once('ical.php');
if (!isset($_GET['ical_link']))
	die('');
$link = $_GET['ical_link'];
if (filter_var($link, FILTER_VALIDATE_URL))
$ical = file_get_contents($link);
if (strlen($ical) == 0)
	die('');
$c = parseIcal($ical);
$checkSummary = isset($_GET['summary']);
$checkDescription = isset($_GET['description']);
$regex = '.*';
if (isset($_GET['regex'])) {
	$regex = $_GET['regex'];
}
echo $c->toFilteredString($regex,$checkSummary,$checkDescription);
?>