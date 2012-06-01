<?php

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
