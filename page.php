<?php
// this is where dynamic graphs are displayed

?>
<html>

<head>
<script type="text/javascript" src="./js/d3.min.js"></script>
<script type="text/javascript" src="./js/openfisheries.js"></script>
</head>

<body>
<script type="text/javascript">
d3.json('http://localhost/openfisheries.org/api/landings.php?format=d3json&iso3c=JPN&api_key=andrew1243', function(json) {
	data = json.data;
	visualizeit();
});
</script>
</body>
</html>
