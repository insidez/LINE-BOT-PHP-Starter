<?php
$access_token = '7BlWXQJod79JKrNRWi30VhISInBh7MeZUbCHE8QTEpPQdyeoBp4J88Sb9DUXH24GdnpBE+13E4RrL+PyMjjmnrNShmlVK7SyHM+u7J0ND05gCfilB9HhlaIDZ/tqTb5k0lnXc+4cQYqZBL3Ur5nvtgdB04t89/1O/w1cDnyilFU=';


$content = file_get_contents('php://input');
$events = json_decode($content, true);

if (!is_null($events['events'])) {

	foreach ($events['events'] as $event) {

		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {

			$checkText = $event['message']['text'];
			
			$replyToken = $event['replyToken'];
			
			if($checkText == '/multiline')
			{
				$text = 'ข้อความ';
				for($i = 1;$i <= 5;$i++)
				{
					$messages[] = array('type' => 'text','text' => $text." : ".$i);
				}
			}
			else if($checkText == '/info'){
				$text = "";
				foreach ($event as $hkey => $hvalue)
				{
					foreach ($hvalue as $lkey => $lvalue){
						$text += "[".$lkey." : ".$lvalue."]";
					}
				}
				
				$messages[] = array('type' => 'text','text' => $text);
				
			}else
			{
				$messages[] = array('type' => 'text','text' => "Please Try Again");
			}
			/*for test*
			$subMessages[] = array('type' => 'text','text' => '1');
			$subMessages[] = array('type' => 'text','text' => '2');
			
			$dataTest = [
				'replyToken' => "11111111",
				'messages' => $subMessages,
			];
			
			$jsonTest = json_encode($dataTest);
			$messages = ['type' => 'text','text' => $jsonTest];*/
			
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => $messages,
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
