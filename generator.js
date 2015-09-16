function generate() {
	str = "http://thefaceless.be/icalQuery/ical.ics?ical_link="
	url = encodeURIComponent(document.getElementById('ical_url').value).replace(/\./g,'%2E');
	if (typeof(url) == 'undefined' || url == null || url == '') {
		return false;
	}
	str += url;
	regex = encodeURIComponent(document.getElementById('regex').value).replace(/\./g, '%2E');
	if (typeof(regex) == 'undefined' || regex == null || regex == '') {
		return false;
	}
	str += '&regex=' + regex;
	if (document.getElementById('search_summary').checked) {
		str += '&summary';
	}
	if (document.getElementById('search_description').checked) {
		str += '&description';
	}
	document.getElementById('out').value = str;
    return false;
}