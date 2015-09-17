<html>
	<head>
		<title>ical query generator</title>
		<link rel="stylesheet" type="text/css" href="generator.css">
	</head>
	<body>
		<form action="#" id="f">
			<label for="ical_url">Original .ics file url: </label>
			<input type="text" name="ical_url" id="ical_url">
			<br />
			<br />
			<label for="regex">Regular expression: </label>
			<input type="text" name="regex" id="regex">
			<br />
			<label for="search_summary">Search in summary: </label>
			<input type="checkbox" name="search_summary" id="search_summary" checked="">
			<br />
			<label for="search_description">Search in description: </label>
			<input type="checkbox" name="search_description" id="search_description" checked="">
			<br />
			<br />
			<label for="regex">Regular expression (NOT): </label>
			<input type="text" name="regex_not" id="regex_not">
			<br />
			<label for="search_summary">Search in summary: </label>
			<input type="checkbox" name="search_summary_not" id="search_summary_not">
			<br />
			<label for="search_description">Search in description: </label>
			<input type="checkbox" name="search_description_not" id="search_description_not">
			<br />
			<br />
			<input type="submit" value="Generate Link" onclick="return generate();">
		</form>
		<br />
		<br />
		<br />
		<input type="text" id="out">
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<p>Info: takes the original .ics file and parses it. Keeps only the events that contain the first regex and that do not contain the second regex (according to the fields to search in).
	</body>
	<script type="text/javascript" src="generator.js"></script>
</html>