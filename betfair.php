<?php
	ini_set('display_errors', 'on');

	$appKey = 'PUNILcvVQFbDezKc';
	$sessionToken = 'm+Fy2gMdlON/C0SZI4D4icL4g14stE6mw8y4Dijes+Q=';
	

// echo extractHorseRacingEventTypeId(getAllEventTypes($appKey, $sessionToken));
 
 print_r(getAllEventTypes($appKey, $sessionToken));
 
function getAllEventTypes($appKey, $sessionToken)
{
 
    $jsonResponse = sportsApingRequest($appKey, $sessionToken, 'listEvents', '{"filter":{"eventTypeIds":["1"],"marketCountries":["PL"]}}');
 
    return $jsonResponse;
}
 
function extractHorseRacingEventTypeId($allEventTypes)
{
    foreach ($allEventTypes as $eventType) {
        if ($eventType->eventType->name == 'Soccer') {
            return $eventType->eventType->id;
        }
    }
}

function sportsApingRequest($appKey, $sessionToken, $operation, $params)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://beta-api.betfair.com/json-rpc");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-Application: ' . $appKey,
        'X-Authentication: ' . $sessionToken,
        'Accept: application/json',
        'Content-Type: application/json'
    ));
 
    $postData =
        '[{ "jsonrpc": "2.0", "method": "SportsAPING/v1.0/' . $operation . '", "params" :' . $params . ', "id": 1}]';
 
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
 
    $response = json_decode(curl_exec($ch));
    curl_close($ch);
 
    if (isset($response[0]->error)) {
        echo 'Call to api-ng failed: ' . "\n";
        echo  'Response: ' . json_encode($response);
        exit(-1);
    } else {
        return $response;
    }
 
}
?>