<?php

$curl = curl_init();

$postData = array(
	'source' => array(
		'card' => array(
			'accountNumber' => '5454545454545454',
			'expiration' => '11/2026',
			'nameOnAccount' => "John Doe",
			'securityCode' => '918'
	)));

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://staging-api.paperlesstrans.com/profiles/create",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($postData),
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache",
    "Content-Type: application/json",
    "TerminalKey: 926fde32e9cf47c7862c7e0a5409",
    "TestFlag: true"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) 
{
  echo "Error #:" . $err;
} 
else 
{
	var_dump($response); //String in JSON format
	$response = json_decode($response);
	if($response->statusCode == "C")
	{
		$profileNumber = $response->profile->profileNumber;
		echo "Profile Number: " . $profileNumber;
	}
	else
	{
		echo 'Error Reference ID: ' . $response->referenceId;
		echo ' ';
		echo 'Error Message: ' . $response->message;
	}
}
?>