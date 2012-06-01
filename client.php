<?php

$server_name = 'server';

?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<title>smart-client</title>
		<link type="text/css" rel="stylesheet" href="style.css" />
		<script type="text/javascript" src="client.js"></script>
	</head>

	<body>
		<h1>smart-client for <?php echo $server_name; ?></h1>
		<form id = "request_form" action = "server.php">
			<table>
				<tr>
					<td>Requester:</td><td><input type = "text" size = "29" name = "principal" /></td>
					<td rowspan = "4"><div id = "output"></div></td>
				</tr>
				<tr>
					<td>Credentials:</td><td><input type = "text" size = "29" name = "credentials" /></td>
				</tr>
				<tr>
					<td>Request:</td><td><input type = "text" size = "29" name = "request" /></td>
				</tr>
				<tr>
					<td>Addresses:</td><td><textarea name = "addresses" rows = "10" cols = "30"></textarea></td>
				</tr>
				<tr>
					<td><input type = "submit" value = "Submit" onclick = "document.getElementById('output').innerHTML = ''; handleRequest(this.form, addressBook(this.form.addresses.value)); return false;" /></td>
				</tr>
			</table>
		</form>
		<table>
			<tr>
				<td id = "left"><a href = "http://validator.w3.org/check?uri=referer">Valid XHTML 1.0 Strict</a></td>
				<td id = "right"><a href = "http://jigsaw.w3.org/css-validator/check/referer">Valid CSS</a></td>
			</tr>
		</table>
	</body>
</html>
