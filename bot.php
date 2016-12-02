<?php
$access_token = '7BlWXQJod79JKrNRWi30VhISInBh7MeZUbCHE8QTEpPQdyeoBp4J88Sb9DUXH24GdnpBE+13E4RrL+PyMjjmnrNShmlVK7SyHM+u7J0ND05gCfilB9HhlaIDZ/tqTb5k0lnXc+4cQYqZBL3Ur5nvtgdB04t89/1O/w1cDnyilFU=';


$content = file_get_contents('php://input');
$events = json_decode($content, true);

if (!is_null($events['events'])) {

	foreach ($events['events'] as $event) {

		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {

			$checkText = $event['message']['text'];
			
			$replyToken = $event['replyToken'];
			
			if($checkText == 'ทดสอบ')
			{
				$text = 'ข้อความ';
			}
			
			//$messages = ['type' => 'text','text' => $text." : ".$checkText];
			$messages = array();
			array_push($messages,'type' => 'text','text' => $text);
			/*for($i = 0;$i < 5;$i++)
			{
				array_push($messages,'type' => 'text','text' => $text);
			}*/
			
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
