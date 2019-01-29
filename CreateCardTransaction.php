<?php

$curl = curl_init();

$postData = array(
    'amount' => array(
		'currency' => 'USD',
		'value' => '2.21'
	),
	'source' => array(
		'card' => array(
			'accountNumber' => '5454545454545454',
			'expiration' => '09/2019',
			'nameOnAccount' => "John Doe",
			'securityCode' => '917'
		)));

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://staging-api.paperlesstrans.com/transactions/capture",
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
	echo "cURL Error #:" . $err;
} 
else 
{
	var_dump($response); //String in JSON format
	$response = json_decode($response);
	if($response->statusCode == "C")
	{
		$authNumber = $response->transaction->authorizationNumber;
		echo "Authorization Number: " . $authNumber;
	}
	else
	{
		echo 'Error Reference ID: ' . $response->referenceId;
		echo ' ';
		echo 'Error Message: ' . $response->message;
	}
}
?>