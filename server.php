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

$smart_reasoner = './credentials.gnu';
$policy = 'policy.pl';

function c2a($c) {
	preg_match_all('/\[(.*?)\]/', $c, $a);
	return($a[1]);
}

$args_error = false;

if(isset($_POST['principal']) && isset($_POST['credentials']) && isset($_POST['request']))
	$args = array_map('escapeshellarg', array($_POST['principal'], $_POST['credentials'], $_POST['request']));
elseif(isset($_POST['principal']) && !isset($_POST['credentials']) && isset($_POST['request']))
	$args = array_map('escapeshellarg', array($_POST['principal'], $_POST['request']));
else
	$args_error = true;

if(!$args_error) {
	$command = $smart_reasoner . ' ' . $policy . ' ' . implode(' ', $args);
	exec($command, $output);
	if(isset($output[2])) {
		if(preg_match('/^{.*}$/', $output[2])) {
			$conj = explode(';', substr($output[2], 1, -1));
			echo json_encode(array_map('c2a', $conj));
		} elseif($output[2] == 'granted')
			echo json_encode("granted");
	} else
		echo json_encode("Smart-reasoner error: " . $output[1]);
} else
	echo json_encode("Arguments error!");

?>
