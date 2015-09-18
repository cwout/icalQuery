<?php

class VCalender {
	
	private $_version = '';
	private $_prodid = '';
	private $_method = '';
	private $_calscale = '';
	private $_name = '';
	private $_timezone = '';
	private $_description = '';
	private $_ttl = '';
	private $_miscParams = array();
	private $_events = array();

	//------------------------------------------------------------------

	public function init($version, $prodid, $method, $calscale, $name, $timezone, $description, $ttl) {
		$this->_version = $version;
		$this->_prodid = $prodid;
		$this->_method = $method;
		$this->_calscale = $calscale;
		$this->_name = $name;
		$this->_timezone = $timezone;
		$this->_description = $description;
		$this->_ttl = $ttl;
		$this->_miscParams = array();
		$this->_events = array();
	}

	public function __construct() {
		$this->init('','','','','','','','');
	}

	//------------------------------------------------------------------

	public function toString() {
		$out = "BEGIN:VCALENDAR\r\n";
		$out .= 'VERSION:' . $this->_version . "\r\n";
		$out .= "PRODID:$this->_prodid\r\n";
		$out .= "METHOD:$this->_method\r\n";
		$out .= "CALSCALE:$this->_calscale\r\n";
		$out .= "X-WR-CALNAME:$this->_name\r\n";
		$out .= "X-WR-TIMEZONE:$this->_timezone\r\n";
		$out .= "X-WR-CALDESC:$this->_description\r\n";
		$out .= "X-PUBLISHED-TTL:$this->_ttl";
		$misc = $this->getMiscParams();
		if (!is_null($misc) && trim($misc) != '')
			$out .= "\r\n$misc";
		for ($i = 0; $i < count($this->_events); $i++) {
			if ($this->_events[$i] != NULL)
				$out .= "\r\n" . $this->_events[$i]->toString();
		}
		$out .= "\r\nEND:VCALENDAR";
		$out = fold($out);
		return $out;
	}


	public function filter ($regex, $summary, $description, $regexNot, $summaryNot, $descriptionNot) {
		$this->_events = array_slice($this->_events, 0, NULL);
		for ($i = 0; $i < count($this->_events); $i++) {
			$inSummary = $summary && (!$summary || preg_match('/'.$regex.'/i', $this->_events[$i]->getSummary()));
			$inDescription = $description && (!$description || preg_match('/'.$regex.'/i', $this->_events[$i]->getDescription()));
			$inSummaryNot = $summaryNot && preg_match('/'.$regexNot.'/i', $this->_events[$i]->getSummary());
			$inDescriptionNot = $descriptionNot && preg_match('/'.$regexNot.'/i', $this->_events[$i]->getDescription());
			$regexOkay = (!$summary && !$description) || $inSummary || $inDescription;
			$regexNotOkay = !$inSummaryNot && !$inDescriptionNot;
			if (!($regexOkay && $regexNotOkay)) {
				unset($this->_events[$i]);
				$this->_events[$i] = NULL;
			}
		}
		$new = array();
		foreach ($this->_events as $value) {
			if ($value != NULL)
				$new[] = $value;
		}
		$this->_events = $new;
	}


	public function toFilteredString ($regex, $summary, $description, $regexNot, $summaryNot, $descriptionNot) {
		$out = "BEGIN:VCALENDAR\r\n";
		$out .= 'VERSION:' . $this->_version . "\r\n";
		$out .= "PRODID:$this->_prodid\r\n";
		$out .= "METHOD:$this->_method\r\n";
		$out .= "CALSCALE:$this->_calscale\r\n";
		$out .= "X-WR-CALNAME:$this->_name\r\n";
		$out .= "X-WR-TIMEZONE:$this->_timezone\r\n";
		$out .= "X-WR-CALDESC:$this->_description\r\n";
		$out .= "X-PUBLISHED-TTL:$this->_ttl";
		$misc = $this->getMiscParams();
		if (!is_null($misc) && trim($misc) != '')
			$out .= "\r\n$misc";
		for ($i = 0; $i < count($this->_events); $i++) {
			$inSummary = $summary && (!$summary || preg_match('/'.$regex.'/i', $this->_events[$i]->getSummary()));
			$inDescription = $description && (!$description || preg_match('/'.$regex.'/i', $this->_events[$i]->getDescription()));
			$inSummaryNot = $summaryNot && preg_match('/'.$regexNot.'/i', $this->_events[$i]->getSummary());
			$inDescriptionNot = $descriptionNot && preg_match('/'.$regexNot.'/i', $this->_events[$i]->getDescription());
			$regexOkay = (!$summary && !$description) || $inSummary || $inDescription;
			$regexNotOkay = !$inSummaryNot && !$inDescriptionNot;
			if ($regexOkay && $regexNotOkay)
				$out .= "\r\n" . $this->_events[$i]->toString();
		}
		$out .= "\r\nEND:VCALENDAR";
		$out = fold($out);
		return $out;
	}

	//------------------------------------------------------------------

	public function getVersion () {
		return $this->_version;
	}
	public function setVersion ($v) {
		$this->_version = $v;
	}


	public function getProdid () {
		return $this->_prodid;
	}
	public function setProdid ($p) {
		$this->_prodid = $p;
	}


	public function getMethod () {
		return $this->_method;
	}
	public function setMethod ($m) {
		$this->_method = $m;
	}


	public function getCalscale () {
		return $this->_calscale;
	}
	public function setCalscale ($cs) {
		$this->_calscale = $cs;
	}


	public function getName () {
		return $this->_name;
	}
	public function setName ($n) {
		$this->_name = $n;
	}


	public function getTimezone () {
		return $this->_timezone;
	}
	public function setTimezone ($tz) {
		$this->_timezone = $tz;
	}


	public function getDescription () {
		return $this->_description;
	}
	public function setDescription ($d) {
		$this->_description = $d;
	}


	public function getTtl () {
		return $this->_ttl;
	}
	public function setTtl ($t) {
		$this->_ttl = $t;
	}


	public function getMiscParamArray() {
		return $this->_miscParams;
	}
	public function getMiscParams() {
		$r = '';
		for ($i = 0; $i < count($this->_miscParams); $i++) {
			$r = $r . $this->_miscParams[$i];
			if ($i < count($this->_miscParams)-1)
				$r = $r . "\r\n";
		}
		return $r;
	}
	public function addMiscParam($p) {
		$this->_miscParams[] = $p;
	}


	public function getEventArray() {
		return $this->_events;
	}
	public function getEventAmount() {
		return count($this->_events);
	}
	public function getEvent($i) {
		return $this->_events[$i];
	}
	public function addEvent($e) {
		$this->_events[] = $e;
	}
	
}

//------------------------------------------------------------------
//------------------------------------------------------------------

class VEvent {

	private $_dtStart = '';
	private $_dtEnd = '';
	private $_sequence = '';
	private $_summary = '';
	private $_description = '';
	private $_uid = '';
	private $_dtStamp = '';
	private $_class = '';
	private $_miscParams = array();

	//------------------------------------------------------------------

	public function init($dtStart, $dtEnd, $sequence, $summary, $description, $uid, $dtStamp, $class) {
		$this->_dtStart = $dtStart;
		$this->_dtEnd = $dtEnd;
		$this->_sequence = $sequence;
		$this->_summary = $summary;
		$this->_description = $description;
		$this->_uid = $uid;
		$this->_dtStamp = $dtStamp;
		$this->_class = $class;
		$this->_miscParams = array();
	}

	public function __construct() {
		$this->init('','','','','','','','');
	}

	//------------------------------------------------------------------
	
	public function toString() {
		$out = "BEGIN:VEVENT\r\n";
		$out .= "DTSTART:$this->_dtStart\r\n";
		$out .= "DTEND:$this->_dtEnd\r\n";
		$out .= "SEQUENCE:$this->_sequence\r\n";
		$out .= "SUMMARY:$this->_summary\r\n";
		$out .= "DESCRIPTION:$this->_description\r\n";
		$out .= "UID:$this->_uid\r\n";
		$out .= "DTSTAMP:$this->_dtStamp\r\n";
		$out .= "CLASS:$this->_class\r\n";
		$misc = $this->getMiscParams();
		if (!is_null($misc) && trim($misc) != '')
			$out .= "\r\n$misc";
		$out .= 'END:VEVENT';
		return $out;
	}

	//------------------------------------------------------------------

	public function getDtStart() {
		return $this->_dtStart;
	}
	public function setDtStart($s) {
		$this->_dtStart = $s;
	}


	public function getDtEnd() {
		return $this->_dtEnd;
	}
	public function setDtEnd($e) {
		$this->_dtEnd = $e;
	}


	public function getSequence() {
		return $this->_sequence;
	}
	public function setSequence($s) {
		$this->_sequence = $s;
	}


	public function getSummary() {
		return $this->_summary;
	}
	public function setSummary($s) {
		$this->_summary = $s;
	}


	public function getDescription() {
		return $this->_description;
	}
	public function setDescription($d) {
		$this->_description = $d;
	}


	public function getUid() {
		return $this->_uid;
	}
	public function setUid($uid) {
		$this->_uid = $uid;
	}


	public function getDtStamp() {
		return $this->_dtStamp;
	}
	public function setDtStamp($s) {
		$this->_dtStamp = $s;
	}


	public function getClass() {
		return $this->_class;
	}
	public function setClass($c) {
		$this->_class = $c;
	}


	public function getMiscParams() {
		$r = '';
		for ($i = 0; $i < count($this->_miscParams); $i++) {
			$r = $r . $this->_miscParams[$i];
			if ($i < count($this->_miscParams)-1)
				$r = $r . "\r\n";
		}
	}
	public function addMiscParam($p) {
		$this->_miscParams[] = $p;
	}

}

function foldLine ($str) {
	$s = array();
	$s[] = substr($str, 0, 75);
	while (strlen($str) > 75) {
		$str = substr($str, 75);
		$s[] = substr($str, 0, 75);
	}
	$str = '';
	for ($i = 0; $i < count($s); $i++) {
		for ($j = 0; $j < $i; $j++) {
			$str = $str . ' ';
		}
		$str = $str . $s[$i];
		if ($i < count($s)-1) {
			$str = $str . "\r\n";
		}
	}
	return $str;
}

function fold ($str) {
	$out = '';
	$lines = explode("\r\n",$str);
	for ($i = 0; $i < count($lines); $i++) {
		$out = $out . foldLine($lines[$i]);
		if ($i < count($lines)-1)
			$out = $out . "\r\n";
	}
	return $out;
}

function unfold ($str) {
	$lines = array();
	$curLines = explode("\r\n",$str);
	$index = 0;
	$n = count($curLines);
	while ($index < $n) {
		$tmp = $curLines[$index];
		$linesUsed = 1;
		$prefixSpaces = ' ';
		while ($index + $linesUsed < $n && substr($curLines[$index+$linesUsed], 0, $linesUsed) === $prefixSpaces) {
			$tmp = $tmp . substr($curLines[$index+$linesUsed], $linesUsed);
			$prefixSpaces = $prefixSpaces . ' ';
			$linesUsed++;
		}
		$lines[] = $tmp;
		$index += $linesUsed;
	}
	$out = '';
	for ($i = 0; $i < count($lines); $i++) {
		$out = $out . $lines[$i];
		if ($i < count($lines)-1)
			$out = $out . "\r\n";
	}
	return $out;
}

function mergeIcal ($ical1, $ical2) {
	$out = new VCalender();
	$out->init($ical1->getVersion(), $ical1->getProdid(), $ical1->getMethod(), $ical1->getCalscale(), $ical1->getName(), $ical1->getTimezone(), $ical1->getDescription(), $ical1->getTtl());
	$tmpMiscParams = array_merge($ical1->getMiscParamArray(),$ical2->getMiscParamArray());
	foreach ($tmpMiscParams as $param) {
		$out->addMiscParam($param);
	}
	$tmpEvents = array_merge($ical1->getEventArray(), $ical2->getEventArray());
	foreach ($tmpEvents as $event) {
		$out->addEvent($event);
	}
	return $out;
}

function parseIcal ($str) {
	//split in lines, little check
	$str = str_replace("\r", '', $str);
	$lines = explode("\n",unfold($str));
	$n = count($lines);
	if ($n < 2) {
		return null;
	}
	for ($i = 0; $i < $n; $i++) {
		$lines[$i] = trim($lines[$i]);
	}

	//initialize index
	$index = 0;
	//remove empty lines in front
	while ($index < $n && ($lines[$index] == null || $lines[$index] == '')) $index++;
	//check if first line is correct
	if ($index < $n && trim($lines[$index]) != 'BEGIN:VCALENDAR') {
		return null;
	}
	$index++;

	//make a new calendar
	$cal = new VCalender();
	while ($index < $n) {
		if (is_null($lines[$index]) || trim($lines[$index]) == '') {
			$index++;
			continue;
		}
		$lineParsed = false;
		$query = 'VERSION:';
		if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query) {
			$cal->setVersion(substr($lines[$index], strlen($query)));
			$lineParsed = true;
		}
		$query = 'PRODID:';
		if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query){
			$cal->setProdid(substr($lines[$index], strlen($query)));
			$lineParsed = true;
		}
		$query = 'METHOD:';
		if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query){
			$cal->setMethod(substr($lines[$index], strlen($query)));
			$lineParsed = true;
		}
		$query = 'CALSCALE:';
		if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query){
			$cal->setCalscale(substr($lines[$index], strlen($query)));
			$lineParsed = true;
		}
		$query = 'X-WR-CALNAME:';
		if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query){
			$cal->setName(substr($lines[$index], strlen($query)));
			$lineParsed = true;
		}
		$query = 'X-WR-TIMEZONE:';
		if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query){
			$cal->setTimezone(substr($lines[$index], strlen($query)));
			$lineParsed = true;
		}
		$query = 'X-WR-CALDESC:';
		if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query){
			$cal->setDescription(substr($lines[$index], strlen($query)));
			$lineParsed = true;
		}
		$query = 'X-PUBLISHED-TTL:';
		if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query){
			$cal->setTtl(substr($lines[$index], strlen($query)));
			$lineParsed = true;
		}
		$query = 'BEGIN:VEVENT';
		if (!$lineParsed && trim($lines[$index]) === $query){
			$ev = new VEVENT();
			$index++;
			while ($index < $n && trim($lines[$index]) != 'END:VEVENT') {
				if (is_null($lines[$index]) || trim($lines[$index]) == '') {
					$index++;
					continue;
				}
				$lineParsed = false;
				$query = 'DTSTART:';
				if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query) {
					$ev->setDtStart(substr($lines[$index], strlen($query)));
					$lineParsed = true;
				}
				$query = 'DTEND:';
				if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query) {
					$ev->setDtEnd(substr($lines[$index], strlen($query)));
					$lineParsed = true;
				}
				$query = 'SEQUENCE:';
				if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query) {
					$ev->setSequence(substr($lines[$index], strlen($query)));
					$lineParsed = true;
				}
				$query = 'SUMMARY:';
				if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query) {
					$ev->setSummary(substr($lines[$index], strlen($query)));
					$lineParsed = true;
				}
				$query = 'DESCRIPTION:';
				if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query) {
					$ev->setDescription(substr($lines[$index], strlen($query)));
					$lineParsed = true;
				}
				$query = 'UID:';
				if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query) {
					$ev->setUid(substr($lines[$index], strlen($query)));
					$lineParsed = true;
				}
				$query = 'DTSTAMP:';
				if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query) {
					$ev->setDtStamp(substr($lines[$index], strlen($query)));
					$lineParsed = true;
				}
				$query = 'CLASS:';
				if (!$lineParsed && substr($lines[$index], 0, strlen($query)) === $query) {
					$ev->setClass(substr($lines[$index], strlen($query)));
					$lineParsed = true;
				}
				if (!$lineParsed) {
					$parts = explode(':',$lines[$index]);
					if (count($parts > 1)) {
						$good = false;
						for ($i = 0; $i < count($parts)-1 && !$good; $i++) {
							if (strlen($parts[$i] > 0 && substr($parts[$i], strlen($parts[$i])-1) !== '\\')) {
								$good = true;
							}
						}
						if ($good) {
							$ev->addMiscParam($lines[$index]);
							$lineParsed = true;
						}
					}
				}
				$index++;
			}
			$cal->addEvent($ev);
			$lineParsed = true;
		}
		$query = 'END:VCALENDAR';
		if (!$lineParsed && $lines[$index] === $query){
			return $cal;
		}
		if (!$lineParsed) {
			$parts = explode(':',$lines[$index]);
			if (count($parts > 1)) {
				$good = false;
				for ($i = 0; $i < count($parts)-1 && !$good; $i++) {
					if (strlen($parts[$i]) > 0 && substr($parts[$i], strlen($parts[$i])-1) !== '\\') {
						$good = true;
					}
				}
				if ($good) {
					$cal->addMiscParam($lines[$index]);
					$lineParsed = true;
				}
			}
		}
		$index++;
	}
}

?>