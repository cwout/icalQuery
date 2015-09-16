<html>
<head>
	<title>ical query generator</title>
	<link rel="stylesheet" type="text/css" href="generator.css">
</head>
<body>
<form action="#" id="f">
<label for="ical_url">Original .ics file url: </label>
<input type="text" name="ical_url" id="ical_url">
<br/>
<label for="regex">Regular expression: </label>
<input type="text" name="regex" id="regex">
<br />
<label for="search_summary">Search in summary: </label>
<input type="checkbox" name="search_summary" id="search_summary" checked="true">
<br/>
<label for="search_description">Search in description: </label>
<input type="checkbox" name="search_description" id="search_description" checked="true">
<br/>
<input type="submit" value="Generate Link" onclick="return generate();">
</form>
<br />
<br />
<br />
<input type="text" id="out">
</body>
<script type="text/javascript" src="generator.js"></script>
</html>