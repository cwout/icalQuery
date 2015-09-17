<?php
//parse ical file
require_once('ical.php');
if (!isset($_GET['ical_link']))
	die('');
$link = $_GET['ical_link'];
if (filter_var($link, FILTER_VALIDATE_URL))
$ical = file_get_contents($link);
if (strlen($ical) == 0)
	die('');
$c = parseIcal($ical);
//get filters from url
$checkSummary = isset($_GET['summary']);
$checkDescription = isset($_GET['description']);
$regex = '.';
if (isset($_GET['regex'])) {
	$regex = $_GET['regex'];
}
//get not-filters from url
$checkSummaryNot = isset($_GET['summary_not']);
$checkDescriptionNot = isset($_GET['description_not']);
$regexNot = '.';
if (isset($_GET['regex_not'])) {
	$regexNot = $_GET['regex_not'];
}
//echo
echo $c->toFilteredString($regex,$checkSummary,$checkDescription,$regexNot,$checkSummaryNot,$checkDescriptionNot);
?>