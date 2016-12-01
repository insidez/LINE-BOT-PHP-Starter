


<?php
$access_token = '7BlWXQJod79JKrNRWi30VhISInBh7MeZUbCHE8QTEpPQdyeoBp4J88Sb9DUXH24GdnpBE+13E4RrL+PyMjjmnrNShmlVK7SyHM+u7J0ND05gCfilB9HhlaIDZ/tqTb5k0lnXc+4cQYqZBL3Ur5nvtgdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
