<?php

/*
 
   Copyright 2012 Daniele Rispoli, Valerio Genovese, Deepak Garg

   This file is part of smart-rsync.

   smart-rsync is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as
   published by the Free Software Foundation, either version 3 of the
   License, or (at your option) any later version.

   smart-rsync is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public
   License along with smart-rsync.  If not, see <http://www.gnu.org/licenses/>.

 */

session_start();
$credentials = 'b says df2';
$request = 'df2';
$addresses = 'a,server_a.php';

?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<title>OK</title>
		<link type="text/css" rel="stylesheet" href="style.css" />
		<script type="text/javascript" src="client.js"></script>
	</head>

	<body>
        <?php
        if($_SESSION['username'] == '')
            echo '<h1>You are not authorized to view this page, <a href =\'login.html\'>try again</a>.</h1>';
        else {
        ?>
        <h1>Requesting ``<?php echo $request; ?>''</h1>
        <h2>Explanation:</h2>
        <p>In this page you are trying to request ``<?php echo $request; ?>'' to the local service. Unfortunately it does not have any information whatsoever on what df2 is and so it cannot authorize you. Even if ``a'' is mentioned it has no reason to initiate a remote request because yours is not mentioned anywhere in its policy.</p>
        <h2>Trying request with these credentials:</h2>
		<form id = "request_form" action = "server.php">
			<table>
				<tr>
                    <td>Requester:</td><td><input type = "text" size = "29" name = "principal" value = "<?php echo $_SESSION['username']; ?>" readonly = "readonly" /></td>
				</tr>
				<tr>
					<td>Credentials:</td><td><input type = "text" size = "29" name = "credentials" value = "<?php echo $credentials; ?>" readonly = "readonly" /></td>
				</tr>
				<tr>
					<td>Request:</td><td><input type = "text" size = "29" name = "request" value = "<?php echo $request; ?>" readonly = "readonly" /></td>
				</tr>
				<tr>
					<td>Addresses:</td><td><input type = "text" size = "29" name = "addresses" value = "<?php echo $addresses; ?>" readonly = "readonly" /></td>
				</tr>
				<tr>
					<td><input type = "submit" value = "Submit" onclick = "document.getElementById('output').innerHTML = ''; handleRequest(this.form, addressBook(this.form.addresses.value)); return false;" /></td>
				</tr>
			</table>
		</form>
        <h2>Result:</h2>
        <div id = "output"></div>
        <?php
        }
        ?>
		<table>
			<tr>
				<td id = "left"><a href = "http://validator.w3.org/check?uri=referer">Valid XHTML 1.0 Strict</a></td>
				<td id = "right"><a href = "http://jigsaw.w3.org/css-validator/check/referer">Valid CSS</a></td>
			</tr>
		</table>
	</body>
</html>
