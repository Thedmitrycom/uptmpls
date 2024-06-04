<?php 
header('X-Powered-By: Uptime.plus v040624c1');
ini_set('display_errors', 1);
ini_set('log_errors', 1);

$currenServerTime = date('H:i j/m/Y');
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

$publicFolder =  strip_tags(htmlspecialchars(addslashes($_SERVER['DOCUMENT_ROOT']))).'/backenduptmpls/';



require_once $backendFolder.'conf098uhjgbn12rfwsd.php';

require_once $backendFolder.'libs/functions.php';

$current_language = 'en';
if($currentDomain == 'ru.publc.uptime.plus') {
	$current_language = 'ru';
}


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

// print_r($puthAsArray);
$template = 404;
$apiStatusCode = 404;
$needAuth = false;

include_once $backendFolder.'libs/mysql.php';
$db = new myuptimeDB($wl_db_host, $wl_db_user, $wl_db_pass);

$typeOfRequest = 'site';
if(!empty($puthAsArray[1]) && $puthAsArray[1] == 'api') {
	header('Content-Type: application/json; charset=utf-8');
	$typeOfRequest = 'api';
	$apiAnswer = array('status' => 404, 'response_status' => 'error', 'response' => array('reason' => 'not found'));
	$backendFolderTemplates = $backendFolderTemplatesAPI;
} else if(!empty($puthAsArray[1]) && $puthAsArray[1] == 'app') {
	$needAuth = true;
	$typeOfRequest = 'app';
} else {
	$typeOfRequest = 'site';
}

$choicedTemplate = 'header_body_prefooter_footer';
if($typeOfRequest == 'site') {

	$htmlCodeStructure = array();
	$htmlCodeStructure['header_body_footer'] = array('static/header', '{body}', 'static/footer'); 
	$htmlCodeStructure['header_menu_body_prefooter_footer'] = array('static/header', 'static/menu', '{body}', 'static/prefooter',  'static/footer');
	$htmlCodeStructure['header_body_prefooter_footer'] = array('static/header', '{body}', 'static/prefooter',  'static/footer');

} else if($typeOfRequest == 'app') {

	$puth = str_replace('/app', '/', $puth);
	$puth = str_replace('/app/', '', $puth);
	$puth = str_replace('//', '', $puth);

	$htmlCodeStructure = array();
	$htmlCodeStructure['header_body_footer'] = array('app/static/header', '{body}', 'app/static/footer'); 
	$htmlCodeStructure['header_menu_body_prefooter_footer'] = array('app/static/header', 'app/static/menu', '{body}', 'app/static/prefooter',  'app/static/footer');
	$htmlCodeStructure['header_body_prefooter_footer'] = array('app/static/header', '{body}', 'app/static/prefooter',  'app/static/footer');

}

require_once $backendFolderTemplates.'/'.$typeOfRequest.'/routing.php';

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

if($typeOfRequest == 'site' || $typeOfRequest == 'app') {

	$translationFile = $backendFolderi18n.'app/global_'.$current_language; 
	$i18nGlobal = new I18nGlobal($current_language, $translationFile);

	$translationFile = $backendFolderi18n.'app/'.$template.'_'.$current_language; 
	$i18n = new I18n($current_language, $translationFile);

	foreach ($htmlCodeStructure[$choicedTemplate] as $key => $oneTmpl) {
		$oneTmpl = str_replace('{body}', $template, $oneTmpl);
		require_once $backendFolderTemplates.$oneTmpl.'.php';
	}
} else {
	require_once $backendFolderTemplates.$template.'.php';
}


if ($typeOfRequest === 'api') {
	http_response_code($apiAnswer['status']);
	echo json_encode($apiAnswer, JSON_UNESCAPED_UNICODE);
	die();
}

?>