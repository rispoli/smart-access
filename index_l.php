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

?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<title>Index page</title>
		<link type="text/css" rel="stylesheet" href="style.css" />
	</head>

	<body>
        <?php
        if($_SESSION['username'] == '')
            echo '<h1>You are not authorized to view this page, <a href =\'login.html\'>try again</a>.</h1>';
        else {
            echo '<h1>Hello, ' . $_SESSION['username'] . '!</h1>';
            echo '<p><a href = \'ok_with_ccs.php\'>Here you can access with your current credentials.</a></p>';
            echo '<p><a href = \'not_enough_cs.php\'>Here you do not have enough credentials.</a></p>';
        }
        ?>
	</body>
</html>
