<?php
$access_token = '7BlWXQJod79JKrNRWi30VhISInBh7MeZUbCHE8QTEpPQdyeoBp4J88Sb9DUXH24GdnpBE+13E4RrL+PyMjjmnrNShmlVK7SyHM+u7J0ND05gCfilB9HhlaIDZ/tqTb5k0lnXc+4cQYqZBL3Ur5nvtgdB04t89/1O/w1cDnyilFU=';


$content = file_get_contents('php://input');
$events = json_decode($content, true);

if (!is_null($events['events'])) {

	foreach ($events['events'] as $event) {

		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {

			$checkText = $event['message']['text'];
			$checkUser = $event['source']['userId'];
			
			$replyToken = $event['replyToken'];
			
			if($checkUser == 'U40eb83842279e15f7c2891012e201a79')
			{
				$messages[] = array('type' => 'text','text' => "สวัสดีครับ คุณ auckarapon");
			}
			
			if($checkText == '/multiline')
			{
				$text = 'ข้อความ';
				for($i = 1;$i <= 4;$i++)
				{
					$messages[] = array('type' => 'text','text' => $text." : ".$i);
				}
			}
			else if($checkText == '/info'){
				$text = "_";
				foreach ($event as $hkey => $hvalue)
				{
					$text .= "[".$hkey." : ".$hvalue;
					foreach ($hvalue as $lkey => $lvalue){
						$text .= "{".$lkey." : ".$lvalue."}";
					}
					$text .= "]";
				}
				
				$messages[] = array('type' => 'text','text' => $text);
				
			}
			else
			{
				$messages[] = array('type' => 'text','text' => "Please Try Agains");
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
			if($checkText == '/push'){
				$messagesPush[] = array('type' => 'text','text' => "yessssssss");
				$urlPush = 'https://api.line.me/v2/bot/message/push';
				$dataPush = [
					'to' => "U40eb83842279e15f7c2891012e201a79",
					'messages' => $messagesPush,
				];
				$postPush = json_encode($dataPush);
				$headersPush = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
				$chPush = curl_init($urlPush);
				curl_setopt($chPush, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($chPush, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($chPush, CURLOPT_POSTFIELDS, $postPush);
				curl_setopt($chPush, CURLOPT_HTTPHEADER, $headersPush);
				curl_setopt($chPush, CURLOPT_FOLLOWLOCATION, 1);
				$resultPush = curl_exec($chPush);
				curl_close($chPush);
			 }
			 else
			 {
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
			 }
			echo $result . "\r\n";
		}
	}
}
echo "OK";
