<?php


$post_data = array(
  'username' => $_REQUEST["username"],
  'password' => $_REQUEST["password"],
  //'username' => "raghuram.vadapalli@research.iiit.ac.in",
  //'password' => "Hackh1234",
);

//echo $post_data["username"];
//echo $post_data["password"];

system('rm cookie.txt');
system('rm final.html');

//echo 'hi';

$curl_connection = curl_init();
curl_setopt($curl_connection, CURLOPT_URL, 'https://moodle.iiit.ac.in/login/index.php');
curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 100);
curl_setopt($curl_connection, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36");
curl_setopt($curl_connection, CURLOPT_HEADER, 0);
curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_connection, CURLOPT_COOKIEJAR, 'cookie.txt');
curl_setopt($curl_connection, CURLOPT_COOKIEFILE, 'cookie.txt');
curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl_connection, CURLOPT_STDERR, fopen('php://stdout','w'));
curl_setopt($curl_connection, CURLOPT_FRESH_CONNECT, TRUE);
$response = curl_exec($curl_connection);
$info = curl_getinfo($curl_connection);
/*
if (!$response || $info['http_code'] != 303) {
	echo "gone";
  throw new \Exception("Problem encountered during authentication (HTTP Code" . $info['http_code'] . ") - " . curl_error($curl_connection));
}*/
/*
// Get the headers and the response.
$response_parts = explode("\r\n\r\n", $response);
$body = array_pop($response_parts);
$headers = array_pop($response_parts);

// Check for Set Cookie headers and save them for later use.
foreach (explode("\n", $headers) as $i => $h) {
  if (substr($h, 0, 10) === "Set-Cookie"){
    preg_match('/^Set\-Cookie: ([A-Za-z]+)=([0-9A-Za-z%]*);/', $h, $matches);

    // Save the cookies somewhere for later use....
  }
}
curl_close($curl_connection);
*/
curl_setopt($curl_connection, CURLOPT_URL, 'https://moodle.iiit.ac.in/login/index.php');
curl_setopt($curl_connection, CURLOPT_REFERER, 'https://moodle.iiit.ac.in/login/index.php');
curl_setopt($curl_connection, CURLOPT_POST, count($post_data));
curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_data);
$page = curl_exec($curl_connection);

//echo $page;

//preg_match_all('*div*',$page,$out,PREG_PATTERN_ORDER);
//foreach($out[0] as $temp){
//	echo $temp;
//}

$htmlfile='final.html';

file_put_contents($htmlfile,'');

file_put_contents($htmlfile,'<html>'."\n".'<head>'."\n".'<link rel="stylesheet" type="text/css" href="bootstrap.css"></head>'."<body>\n");

$file='extract.html';
file_put_contents($file,$page);

system('python getlinks.py',$retval);

$file2='links.txt';
$links=file_get_contents($file2);

$linkList = explode(PHP_EOL, $links);

$file5='coursenames.txt';
$coursenames=file_get_contents($file5);

$courseNameList = explode("\n", $coursenames);

$val=0;
$temp=0;

file_put_contents($htmlfile,'<div class="list-group">'."\n",FILE_APPEND);

foreach($linkList as $curlink){
	
	if($val==sizeof($linkList)-1){
		break;
	}	

	$file3='course.html';

	curl_setopt($curl_connection, CURLOPT_URL, $curlink);
	curl_setopt($curl_connection, CURLOPT_REFERER, $curlink);
	curl_setopt($curl_connection, CURLOPT_POST, count($post_data));
	curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_data);
	$page = curl_exec($curl_connection);

	file_put_contents($file3,$page);

	system('python getposts.py',$retval);

	$file4='posts.txt';
	$postss=file_get_contents($file4);

	$postssList=explode(PHP_EOL,$postss);


	//file_put_contents($htmlfile,$postss,FILE_APPEND);

	//print "POSTS";
	
	file_put_contents($htmlfile,"<a href='#' class='list-group-item active'>",FILE_APPEND);	
	file_put_contents($htmlfile,"<p class='list-group-item-heading'>".$courseNameList[$val]."</p>\n",FILE_APPEND);
	file_put_contents($htmlfile,"</a>\n",FILE_APPEND);
	$temp=0;
	foreach($postssList as $curpost){
		if($temp==0)
			file_put_contents($htmlfile,"<a href='#' class='list-group-item' style='background-color:#B8B8B8;height:30px;padding-top:5px'>",FILE_APPEND);
		if($temp==1)
			file_put_contents($htmlfile,"<a href='#' class='list-group-item'>",FILE_APPEND);
		file_put_contents($htmlfile,"<p class='list-group-item-text'>".$curpost."</p>\n",FILE_APPEND);
		if($temp==0)
			file_put_contents($htmlfile,"</a>",FILE_APPEND);
		if($temp==2)
			file_put_contents($htmlfile,"</a>",FILE_APPEND);
		$temp=($temp+1)%3;	
	}	
	$val+=1;
}

file_put_contents($htmlfile,"</div>\n</body>\n</html>",FILE_APPEND);

system('rm extract.html links.txt course.html posts.txt');
system('python finaltest.py');

$oldfilefinal='oldfinal.html';
$filefinal='final.html';
$results=file_get_contents($filefinal);
$resultsold=file_get_contents($oldfilefinal);

curl_close($curl_connection);

if($resultsold!=$results){
	//print "HI";
}

file_put_contents($oldfilefinal,$results);

print $results;

?>
