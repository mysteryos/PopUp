<?php
	include("config.php");
	session_start();
	
	if (isset($_POST['datepick2'])) {
		$date = strtotime($_POST['datepick2']);
		$milliseconds = round($date * 1000);
		echo $request_url = url.cdr."?realm=".realm."&ext=".$_POST['exte']."&from=".$milliseconds;
		$gettoken = substr($_SESSION['token'], 0, -1);
		$ch = curl_init();
				
		$request_headers = array();
		$request_headers[] = 'Content-Type: application/json; charset=utf-8';
		$request_headers[] = 'x-auth-token: '.$gettoken;
				
		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
		curl_setopt($ch, CURLOPT_HEADER,FALSE);
				
		$response  = curl_exec($ch);
			
		$response = json_decode($response, true);
		print_r($response);
	} 
?>

<!DOCTYPE html>
<html>
<head>
<title> Kies een datum</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
	$(function() {
		$(".datepick2").datepicker({'dateFormat': 'dd-mm-yy'});
	});
</script>
</head>

<form action='getlist.php' method='post'> 
	<input type='text' name='exte' class='exte' value="<?php echo $_POST['exte']?>">  
	<input type='text' name='datepick2' class='datepick2' value='Kies een datum!'>
	<input type='submit' name='aanvragen' id='aanvragen' value='aanvragen'>
</form>
