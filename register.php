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

require('pbkdf2.php');

?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<title>Register</title>
		<link type="text/css" rel="stylesheet" href="style.css" />
	</head>

	<body>
        <?php
        if($_POST['username'] == '' || $_POST['password'] == '')
            echo '<h1>Username and password MUST be non-empty, <a href =\'register.html\'>try again</a>.</h1>';
        else {
            try {
                $db = new PDO('sqlite:db/users.sqlite');
            } catch(Exception $e) {
                die($e);
            }

            $users = $db->prepare('SELECT username FROM users WHERE username = ?');
            $users->execute(array($_POST['username']));

            if($users->fetch())
                echo '<h1>Username already taken, <a href =\'register.html\'>try again</a>.</h1>';
            else {
                $salt = base64_encode(mcrypt_create_iv(PBKDF2_SALT_BYTES, MCRYPT_DEV_URANDOM));
                $good_hash = create_hash($salt . $_POST['password']);

                $new_user = $db->prepare('INSERT INTO users VALUES (?, ?, ?)');
                $r = $new_user->execute(array($_POST['username'], $good_hash, $salt));

                if($r)
                    echo '<h1>Registration successful, <a href =\'login.html\'>log in</a>.</h1>';
                else {
                    echo '<h1>Registration unsuccessful, contact the administrator.</h1>';
                    echo '<p>' . implode(', ', $new_user->errorInfo()) . '</p>';
                }
            }
        }
        ?>
	</body>
</html>
