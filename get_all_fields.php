<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);


$api_key = "D************os2K";
$password = "*********";
$url = "https://<instance_name>.freshdesk.com/api/v2/ticket_fields";


$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
$info = curl_getinfo($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($server_output, 0, $header_size);
$response = substr($server_output, $header_size);

if($info['http_code'] == 200) {
  $object = $response;
} else {
  if($info['http_code'] == 404) {
    echo "Error, Please check the end point \n";
  } else {
    echo "<br>Error, HTTP Status Code : " . $info['http_code'] . "\n";
    echo "<br><br>Headers are ".$headers;
    echo "<br><br>Response are ".$response;
  }
}
curl_close($ch);

$object = json_decode($object, true);
$strBody = ''; $counter = 1; 

foreach($object as $dd => $dArry) 
{
	//if($dd==1)  // print particular field details
	{
	echo $dd."<br><br>";
	foreach ($dArry as $key => $value)
	{
		if(is_array($value))
		{ 
			if($key == 'choices')
			{
				echo "<strong>1: ".$key."</strong><br>"; $xx=1;
				foreach ($value as $k => $v) 
				{
					if(is_array($v))
					{ 
						echo "&nbsp;&nbsp;&nbsp;<strong>2: ".$k."</strong><br>";
						foreach ($v as $k1 => $v1) 
						{
							echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>3: ".$k1."</strong><br>";
							if(is_array($v1))
							{
								foreach ($v1 as $k2 => $v2) 
								echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ".$k2."->" . $v2."; ";
							}
							else
							{
								echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3: ".$k1."->" . $v1."; ";
							}
						}
						echo "<br>";
					}
					else
					{
						echo "&nbsp;&nbsp;&nbsp;2: ".$k." # " . $v."<br>";
					}
				}
			}
		} 
		else 
		{
			echo "1: ".$key." => " . $value . "<br>";
		}
	}
	
	}
}
?>
