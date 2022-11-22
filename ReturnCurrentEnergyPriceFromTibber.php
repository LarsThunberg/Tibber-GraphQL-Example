<?php
# The JSON query
$json = '{"query":"{viewer {homes {currentSubscription {priceInfo {current {total energy tax startsAt }}}}}}"}';

# Create a connection
$ch = curl_init('https://api.tibber.com/v1-beta/gql');
# Setting our options
curl_setopt($ch, CURLOPT_URL, 'https://api.tibber.com/v1-beta/gql');
curl_setopt($ch, CURLOPT_HTTPHEADER, 
   array('Content-Type: application/json',  
   'Authorization: Bearer THE_API_KEY')); 
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

# Get the response
$response = curl_exec($ch);
curl_close($ch);

# Get the data
$data = json_decode($response);
$current = $data->data->viewer->homes[0];
$total = $current->currentSubscription->priceInfo->current->total;

# Format the date
$startsAt = new DateTime($current->currentSubscription->priceInfo->current->startsAt);
$tz = new DateTimeZone('Europe/Stockholm');
$startsAt->setTimezone($tz);

# Print the data
echo '<b>' .round($total*100, 0) , ' öre  '.$startsAt->format('Y-m-d') , ' kl '.$startsAt->format('H'), ' till '.$startsAt->modify('+ 1 hour')->format('H'), '</b>';
?>
