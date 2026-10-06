<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

$request = getWepToPayRequest($_GET);

if (goodRequest($request)) {
    $respond_text = "OK ";	
    require_once("../../core.php");
    
		$get_sms = explode(" ", $request['sms']);
		$nickname = mysql_real_escape_string($get_sms[1]);
		$amount = mysql_real_escape_string($request['amount']);
	
		$sql = "SELECT id FROM ". MYSQL_PREFIX ."sms_config WHERE price = '". $amount ."'";
		$get_info = mysql::fetchArray($sql);
		$price_id = $get_info['id'];

		$get_sql = "SELECT sms_points FROM ". MYSQL_PREFIX ."sms_config WHERE id = '". mysql_real_escape_string($price_id) ."'";
		$get_data = mysql::fetchArray($get_sql);
		$sms_points = $get_data['sms_points'];
			
		$update_sql = "UPDATE ". MYSQL_PREFIX ."game_r_info SET points = 'points'+ ". $sms_points ." WHERE account_name='". $nickname ."'";
		mysql::query($update_sql);
	
    echo $respond_text .= "Jusu saskaita sekmingai papildyta !";
    
    exit;
} else {
    exit('Bad data!');
}

function getCert($cert = null) {
    $fp = fsockopen("downloads.webtopay.com", 80, $errno, $errstr, 30);
    if (!$fp)
        exit("Cert error: $errstr ($errno)<br />\n");
    else {
        $out = "GET /download/" . ($cert ? $cert : 'public.key') . " HTTP/1.1\r\n";
        $out .= "Host: downloads.webtopay.com\r\n";
        $out .= "Connection: Close\r\n\r\n";
        $content = '';
        fwrite($fp, $out);
        while (!feof($fp)) $content .= fgets($fp, 8192);
        fclose($fp);
        list($header, $content) = explode("\r\n\r\n", $content, 2);
        return $content;
    }
}

function checkCert($request, $cert = null) {
    $pKeyP = getCert($cert);
    if (!$pKeyP) return false;
    $pKey = openssl_pkey_get_public($pKeyP);
    if (!$pKey) return false;
    $_SS2 = "";
    foreach ($request As $key => $value) if ($key!='_ss2') $_SS2 .= "{$value}|";
    $ok = openssl_verify($_SS2, base64_decode($request['_ss2']), $pKey);
    return ($ok === 1);
}

function goodRequest($request) {
    if (checkCert($request)) return true;
    return checkCert($request, 'public_old.key');
}

function getWepToPayRequest($data, $prefix='wp_') {
    if (empty($data[$prefix.'version']) || $data[$prefix.'version'] < '1.2') {
        return $data;
    }

    $ret = array();
    foreach ($data as $key => $val) {
        if (strpos($key, $prefix) === 0 && strlen($key) > 3) {
            $ret[substr($key, 3)] = $val;
        }
    }
    return $ret;
}
?>