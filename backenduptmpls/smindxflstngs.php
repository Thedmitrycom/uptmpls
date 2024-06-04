<?php 
header('X-Powered-By: Uptime.plus v040624c1');
ini_set('display_errors', 1);
ini_set('log_errors', 1);

$currenServerTime = date('H:i j/m/Y');

if(empty($_SERVER['HTTP_HOST'])) {
	die('error_9');
}

$currentDomain = strip_tags(htmlspecialchars(addslashes($_SERVER['HTTP_HOST'])));
$currentDomainAsArray = array();

if(empty($_SERVER['HTTP_USER_AGENT'])) {
	$userAgent = false;
} else {
	$userAgent = strip_tags(htmlspecialchars(addslashes($_SERVER['HTTP_USER_AGENT'])));
}

if(empty($_SERVER['HTTP_REFERER'])) {
	$refFrom = '';
} else {
	$refFrom = strip_tags(htmlspecialchars(addslashes($_SERVER['HTTP_REFERER'])));
}

if(empty($_SERVER['REQUEST_URI'])) {
	$puth = '/';
} else {
	$puth = strip_tags(htmlspecialchars(addslashes($_SERVER['REQUEST_URI'])));
	if($puth != '/') {
		$puthCleanLastSym = substr($puth, -1);
		if($puthCleanLastSym == '/') {
			$puth = substr($puth, 0, -1);
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: ".$puth); 
			die();
		}
	}
}

if(empty($_SERVER['DOCUMENT_ROOT'])) {
	die('error_38');
}
$backendFolder =  strip_tags(htmlspecialchars(addslashes($_SERVER['DOCUMENT_ROOT']))).'/backenduptmpls/';



require_once $backendFolder.'conf098uhjgbn12rfwsd.php';

require_once $backendFolder.'libs/functions.php';



$puthAsArray = explode('/', $puth);
if(empty($puthAsArray[0])) {
	$puthAsArray[0] = '/';
}
foreach ($puthAsArray as $key => $onePuth) {
	if(empty($onePuth)) {
		unset($puthAsArray[$key]);
		continue;
	}
	$onePuth = strip_tags(htmlspecialchars(addslashes($onePuth)));
	$puthAsArray[$key] = $onePuth;
}
$puthAsArray = array_values($puthAsArray);

print_r($puthAsArray);
$template = 404;
$apiStatusCode = 404;
$needAuth = false;

include_once $backendFolder.'libs/mysql.php';
$db = new uptimePlus($wl_db_host, $wl_db_user, $wl_db_pass);

$typeOfRequest = 'app';
if(!empty($puthAsArray[1]) && $puthAsArray[1] == 'api') {
	header('Content-Type: application/json; charset=utf-8');
	$typeOfRequest = 'api';
	$apiAnswer = array('status' => 404, 'response_status' => 'error', 'response' => array('reason' => 'not found'));
	// $backendFolderTemplates = $backendFolderTemplatesAPI;
} else {
	$needAuth = true;
	$typeOfRequest = 'app';
}

$choicedTemplate = 'header_body_prefooter_footer';
if($typeOfRequest == 'app') {

	$puth = str_replace('/app', '/', $puth);
	$puth = str_replace('/app/', '', $puth);
	$puth = str_replace('//', '', $puth);

	$htmlCodeStructure = array();
	$htmlCodeStructure['header_body_footer'] = array('static/header', '{body}', 'static/footer'); 
	$htmlCodeStructure['header_menu_body_prefooter_footer'] = array('static/header', 'static/menu', '{body}', 'static/prefooter',  'static/footer');
	$htmlCodeStructure['header_body_prefooter_footer'] = array('static/header', '{body}', 'static/prefooter',  'static/footer');

}

require_once $backendFolder.'/'.$typeOfRequest.'/routing.php';

if(empty($_COOKIE['mptm']) || empty($_COOKIE['mptm2'])) {
	$mptm = false;
	$mptm2 = false;
} else {
	$mptm = strip_tags(htmlspecialchars(addslashes($_COOKIE['mptm'])));
	$mptm2 = strip_tags(htmlspecialchars(addslashes($_COOKIE['mptm2'])));
}
$isUser = false;

if($needAuth) {

	if(!empty($mptm) && !empty($mptm2) && !$specialFolders) {
		$checkCookies = $db->getRow("SELECT id, user_id, apiKey FROM ?n WHERE mptm=?s and mptm2=?s",'app_users_auth',$mptm, $mptm2);

		if(!empty($checkCookies)) {

		}
	}

	if($isUser) {} else {
		$template = 'system/403';
	}

}

if($typeOfRequest == 'app') {
	foreach ($htmlCodeStructure[$choicedTemplate] as $key => $oneTmpl) {
		$oneTmpl = str_replace('{body}', $template, $oneTmpl);
		require_once $backendFolder.$typeOfRequest.'/'.$oneTmpl.'.php';
	}
} else {
	require_once $backendFolder.$typeOfRequest.'/'.$template.'.php';
}


if ($typeOfRequest === 'api') {
	http_response_code($apiAnswer['status']);
	echo json_encode($apiAnswer, JSON_UNESCAPED_UNICODE);
	die();
}

?>