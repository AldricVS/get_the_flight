<?php
$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://aerodatabox.p.rapidapi.com/flights/number/LFPO/2020-11-29",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: aerodatabox.p.rapidapi.com",
		"x-rapidapi-key: 25dc084f3amsh5f1c553701775f7p17dc7djsn8b6890611d5d"
	],
]);

$response = curl_exec($curl);
var_dump($response);
$err = curl_error($curl);
var_dump($err);
curl_close($curl);

?>