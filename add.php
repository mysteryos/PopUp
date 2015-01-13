<!DOCTYPE html>
<html>
<head>
<title> Call Api Demo</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
<script>
	$(function() {
		$(".datepick2").datepicker({'dateFormat': 'd/m/y'});
	});
</script>


 <script type="text/javascript">
            $('#popupForm').on('submit',function(e){
                var w = window.open('about:blank','Popup_Window','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=400,height=300,left = 312,top = 234');
                this.target = 'Popup_Window';
    });
</script>
	
</head>
<?php

if (isset($_POST['exte'])) {
	echo $_POST['exte'];
}

$data = array('key'=>'b7b8a4ce-b9df-436a-bda5-2e74797a616f');
$data_json = json_encode($data);
$url = "http://fess.firmtel.net:50072/v1/";
$auth = "auth";
$user = "user";

include("config.php");
session_start();

if(empty($_SESSION['username']) ) {
	header('Location:fout.php'); // verbind door.
	exit(); // houdoee
}

function getuser(){   // Wat er gebeurd als je op Load Users drukt
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['submitloadusers']) == 'Load Users') {

			if (!empty($_SESSION['token'])) {
				
				$request_url = url.user."?realm=".realm;
				
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
		//		echo $response  = curl_exec($ch);
		//		print_r($response);
		
				$response = json_decode($response, true);

					echo 	"<table>
							<thead>
							<tr>
							<td>Name</td>
							<td>Last Name</td>
							<td>Email</td>		
							<td>Extension</td>
							<td>Numbers</td>
							<td>Datum</td>
							</tr>"; 	

				foreach ($response as $key => $value) {
				
					echo "
						<tr>
						<td>".$value['fname']."</td>
						<td>".$value['lname']."</td>
						<td>".$value['email']."</td>
						<td>".$value['ext']."</td>
						<td>"; 
					foreach ($value['numbers'] as $key2 => $numvalue) {
					echo $numvalue;
				
					}
					echo "</td>"; 
					echo "<td>";
							echo "<form action='getlist.php' method='post' id='popupForm'> 
					<input type='text' name='exte' class='exte' value=".$value['ext'].">  
					<input type='submit' name='aanvragen' id='aanvragen' value='aanvragen'></form>";
					echo "</td>";
				}
					
				
					echo "
						</tr>
						</thead>
						</table> ";

				
				
				
				
					
				//print_r($response);
				
				curl_close($ch);
				
				
				
			}
			
			//echo"Load User";
		}  
	}
}

function gs() { // wat er gebeurd als je op Get Call History drukt
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($_POST['submitcallhistory']) == 'Get Call History') {

				
				 $milliseconds = round(time() * 1000);
				$request_url = url.cdr."?realm=".realm."&ext=2001&from=".$milliseconds;
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
				echo $response  = curl_exec($ch);
				print_r($response);
		
				$response = json_decode($response, true);
				print_r($response);
		}
    }
}

$alert = "Extension or/and number not filled";

function bellen(){	// Wat er gebeurd als je op call drukt
global $alert;
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['submitcallnow']) == 'Call') {
			if (empty($_POST['extension1']) && empty($_POST['belvak'])) {
			echo "<script type='text/javascript'>alert(" . json_encode($alert) . ");</script>";
			}
				else {
					echo "ingevuld";
				}
		}
	}
}	

function logout() { // wat er gebeurd als je op logout
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($_POST['submitlogout']) == 'Log Out') {
		header('Location:uit.php'); // verbind door.
		exit(); // houdoee
		}
    }
}
	   

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, url.auth);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
curl_setopt($ch, CURLOPT_POST,TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
curl_setopt($ch, CURLOPT_VERBOSE,TRUE);
curl_setopt($ch, CURLOPT_HEADER,TRUE);
$response  = curl_exec($ch);
$headerinfo = curl_getinfo($ch);
list($one, $two, $three, $four, $five, $tokenstring) = explode("\n", $response);
$gettoken = str_replace(' ', '', $tokenstring);
$pieces = explode(":", $gettoken);

$_SESSION['token'] = $pieces[1];

curl_close($ch);


//http://stackoverflow.com/questions/21271140/curl-and-php-how-can-i-pass-a-json-through-curl-by-put-post-get
	?>
	
<body>
<div id="banner"> Call Api Demo 
<form  id="pieter" name="uitlog" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
<input id="uitlog" type="submit" name="submit" value="Log Out">
</form>
</div>
<div id="realm"><p>Realm:<br/></p>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
<input id="f1" type="text" name="realm1" value="<?php echo realm ?>" />
<input id="f2" type="submit" name="submitloadusers" value="Load Users">
<input id="f2" type="submit" name="submitcallhistory" value="Get Call History">
</form>
</div>

<?php

bellen();
gs();
logout();

?>

<div id="extension"> <p>Extension:</p>
 <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
 <input id="f3" type="text" name="extension1"<br/></p>
 </form>
 </div>
 
<div id="call"> <p>Call any number or extension:</p>
 <form name="form3" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
 <input id="f3" type="text" name="belvak"<br/></p>
 <input id="f2" type="submit" name="submitcallnow" value="Call">
 </form>
 </div>
 
<?php
 getuser(); // roept functie op van de gebruikers ophalen
?>
 


</body>
</html>
