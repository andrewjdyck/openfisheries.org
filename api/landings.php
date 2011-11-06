<?php
// openfisheries.org API

include "../functions.php";

// checking output formats and API keys
$check_format = checkOutputFormat($_GET['format']);
if (!check_api($_GET['api_key'])) {
	$error = '[{"error":"Incorrect API key"}]';
} elseif ($check_format['error']) {
	$error = '[{"error":"Incorrect output format"}]';
} else {
	$format = $check_format['format'];
}

// outputs results
if (isset($error)) {
	print $error;
} else {
	output_data($format);
}
?>
