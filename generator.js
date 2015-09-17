function generate() {
	document.getElementById('out').value = "";
	str = "http://thefaceless.be/icalQuery/ical.ics?ical_link="
	url = encodeURIComponent(document.getElementById('ical_url').value).replace(/\./g,'%2E');
	if (typeof(url) == 'undefined' || url == null || url == '') {
		return false;
	}
	str += url;
	regex = encodeURIComponent(document.getElementById('regex').value).replace(/\./g, '%2E');
	r = true;
	regex_not = encodeURIComponent(document.getElementById('regex_not').value).replace(/\./g, '%2E');
	rn = true;
	if (typeof(regex) == 'undefined' || regex == null || regex == '') {
		regex = '';
		r = false;
	}
	if (typeof(regex) == 'undefined' || regex == null || regex_not == '') {
		regex_not = '';
		rn = false;
	}
	if (r) {
		str += '&regex=' + regex;
		if (document.getElementById('search_summary').checked) {
			str += '&summary';
		}
		if (document.getElementById('search_description').checked) {
			str += '&description';
		}
	}
	if (rn) {
		str += '&regex_not=' + regex_not;
		if (document.getElementById('search_summary_not').checked) {
			str += '&summary_not';
		}
		if (document.getElementById('search_description_not').checked) {
			str += '&description_not';
		}
	}
	document.getElementById('out').value = str;
    return false;
}