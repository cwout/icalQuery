var amount = 1;

function generate() {
	//clear output field
	document.getElementById('out').value = "";
	//basic link
	str = "http://thefaceless.be/icalQuery/ical.ics?";
	//parse the first one
	el = [];
	el['url'] = encodeURIComponent(document.getElementById('ical_url').value).replace(/\./g,'%2E');
	el['hasUrl'] = !(typeof(el['url']) == 'undefined' || el['url'] == null || el['url'] == '');
	el['regex'] = encodeURIComponent(document.getElementById('regex').value).replace(/\./g, '%2E');
	el['r'] = true;
	el['regex_not'] = encodeURIComponent(document.getElementById('regex_not').value).replace(/\./g, '%2E');
	el['rn'] = true;
	if (typeof(el['regex']) == 'undefined' || el['regex'] == null || el['regex'] == '') {
		el['r'] = false;
	}
	if (typeof(el['regex_not']) == 'undefined' || el['regex_not'] == null || el['regex_not'] == '') {
		el['rn'] = false;
	}
	el['summary'] = document.getElementById('search_summary').checked;
	el['description'] = document.getElementById('search_description').checked;
	el['summary_not'] = document.getElementById('search_summary_not').checked;
	el['description_not'] = document.getElementById('search_description_not').checked;
	//create the array and push the first one onto the array
	data = [];
	data.push(el);

	//repeat for other files
	for (i = 2; i <= amount; i++) {
		el = new Array();
		el['url'] = encodeURIComponent(document.getElementById('ical_url'+i).value).replace(/\./g,'%2E');
		el['hasUrl'] = !(typeof(el['url']) == 'undefined' || el['url'] == null || el['url'] == '');
		el['regex'] = encodeURIComponent(document.getElementById('regex'+i).value).replace(/\./g, '%2E');
		el['r'] = true;
		el['regex_not'] = encodeURIComponent(document.getElementById('regex_not'+i).value).replace(/\./g, '%2E');
		el['rn'] = true;
		if (typeof(el['regex']) == 'undefined' || el['regex'] == null || el['regex'] == '') {
			el['r'] = false;
		}
		if (typeof(el['regex_not']) == 'undefined' || el['regex_not'] == null || el['regex_not'] == '') {
			el['rn'] = false;
		}
		el['summary'] = document.getElementById('search_summary'+i).checked;
		el['description'] = document.getElementById('search_description'+i).checked;
		el['summary_not'] = document.getElementById('search_summary_not'+i).checked;
		el['description_not'] = document.getElementById('search_description_not'+i).checked;
		if (el['hasUrl'] == true)
			data.push(el);
	}
	console.log(data.length);
	for (i = 0; i < data.length; i++) {
		if (i > 0)
			str += '&';
		str += 'ical_link' + (i==0?'':(i+1)) + '=';
		str += data[i]['url'];
		if (data[i]['r']) {
			str += '&regex' + (i==0?'':(i+1)) + '=' + data[i]['regex'];
			if (data[i]['summary']) {
				str += '&summary' + (i==0?'':(i+1));
			}
			if (data[i]['description']) {
				str += '&description' + (i==0?'':(i+1));
			}
		}
		if (data[i]['rn']) {
			str += '&regex_not' + (i==0?'':(i+1)) + '=' + data[i]['regex_not'];
			if (data[i]['summary_not']) {
				str += '&summary_not' + (i==0?'':(i+1));
			}
			if (data[i]['description_not']) {
				str += '&description_not' + (i==0?'':(i+1));
			}
		}
	}

	document.getElementById('out').value = str;
	return false;
}

function addForm(index) {
	newText = '<hr><br />';
	newText += '<label for="ical_url' + index + '">Original .ics file url: </label>';
	newText += '<input type="text" name="ical_url' + index + '" id="ical_url' + index + '" class="half_width">';
	newText += '<br /><br />';
	newText += '<label for="regex' + index + '">Regular expression: </label>';
	newText += '<input type="text" name="regex' + index + '" id="regex' + index + '" class="half_width">';
	newText += '<br />';
	newText += '<label for="search_summary' + index + '">Search in summary: </label>';
	newText += '<input type="checkbox" name="search_summary' + index + '" id="search_summary' + index + '" checked="">';
	newText += '<br />';
	newText += '<label for="search_description' + index + '">Search in description: </label>';
	newText += '<input type="checkbox" name="search_description' + index + '" id="search_description' + index + '" checked="">';
	newText += '<br /><br />';
	newText += '<label for="regex_not' + index + '">Regular expression (NOT): </label>';
	newText += '<input type="text" name="regex_not' + index + '" id="regex_not' + index + '" class="half_width">';
	newText += '<br />';
	newText += '<label for="search_summary_not' + index + '">Search in summary: </label>';
	newText += '<input type="checkbox" name="search_summary_not' + index + '" id="search_summary_not' + index + '">';
	newText += '<br />';
	newText += '<label for="search_description_not' + index + '">Search in description: </label>';
	newText += '<input type="checkbox" name="search_description_not' + index + '" id="search_description_not' + index + '">';
	newText += '<br /><br />';
	newText += '<a id="new_form_link" href="#" onclick="return addForm(' + (index+1) + ');">Add another .ics file</a>';
	link = document.getElementById('new_form_link').outerHTML = newText;
	amount = index;
	return false;
}