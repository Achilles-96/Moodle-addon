<?php


echo 'You are here';
echo $_REQUEST['username'];
echo $_REQUEST['password'];

echo "HI";

/*
$url = 'https://moodle.iiit.ac.in/login/index.php';
$username = 'user';
$password = 'pass';
$ldap = ldap_connect($url);
var_dump($ldap);*/

//$pp=array('key1' => 'value1', 'key2' => 'value2');
//$data = array('username' => 'raghuram.vadapalli@research.iiit.ac.in', 'password' => 'R@ghu4350R@m');
/*$myRequest = curl_init($url);
curl_setopt($myRequest, CURLOPT_POST, TRUE);
curl_setopt($myRequest, CURLOPT_USERPWD, "$username:$password");
curl_setopt($myRequest, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($myRequest);
var_dump($response);
$statusCode = curl_getinfo($myRequest, CURLINFO_HTTP_CODE);
var_dump($statusCode);
curl_close($myRequest);*/
/*
$options = array(
	'http' => array(
		'header' => "Content-type: application",
		'method' => 'POST',
		'content' => http_build_query($data),
	),
);
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
var_dump($result);*/
?>
