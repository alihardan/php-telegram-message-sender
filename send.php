<?php
require_once("config.php");
require_once("protect.php");
require_once("protect-exec.php");

// Send message to telegram function
function sendMessage($botToken, $chatID, $text) {

	$data = [
		'chat_id' => $chatID,
		'text' => $text
	];

	$url = "https://api.telegram.org/bot$botToken/sendMessage?" . http_build_query($data);

	// Method 1
	// It was banned on our server.
	//return file_get_contents($url);
	
	// Method 2
	$ch = curl_init();
	$optArray = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true
			);
	curl_setopt_array($ch, $optArray);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;

}

function sendPhoto($botToken, $chatID, $caption, $file) {

	$url = "https://api.telegram.org/bot$botToken/sendPhoto";
	$post_fields = [
		'chat_id' => $chatID,
		'caption' => $caption,
		'photo'   => $file
	];
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Content-Type:multipart/form-data"
	));
	$optArray = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => $post_fields
			);
	curl_setopt_array($ch, $optArray);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;

}

function sendVideo($botToken, $chatID, $caption, $file) {

	$url = "https://api.telegram.org/bot$botToken/sendVideo";
	$post_fields = [
		'chat_id' => $chatID,
		'caption' => $caption,
		'video'   => $file
	];
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Content-Type:multipart/form-data"
	));
	$optArray = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => $post_fields
			);
	curl_setopt_array($ch, $optArray);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;

}

function sendAttachment($botToken, $chatID, $caption, $file, $type) {
    if($type=="picture") {
        return sendPhoto($botToken, $chatID, $caption, $file);
    } elseif($type=="video") {
        return sendVideo($botToken, $chatID, $caption, $file);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST["target"]) and !empty($_POST["message"])) {
		if(!empty($targets[$_POST["target"]]["chat_id"])) {
			file_put_contents($recentTargetFile, $_POST["target"]);
			$target_chat_id = $targets[$_POST["target"]]["chat_id"];
			if(!empty($_FILES["attachment_file"]["name"])) {
    	        $result = sendAttachment($botToken, $target_chat_id, $_POST["message"], new CURLFile(realpath($_FILES["attachment_file"]['tmp_name'])), $_POST["attachment_type"]);
			} elseif  (!empty($_POST["attachment_url"])) {
			    $result = sendAttachment($botToken, $target_chat_id, $_POST["message"], $_POST["attachment_url"], $_POST["attachment_type"]);
			} else {
    			$result = sendMessage($botToken, $target_chat_id, $_POST["message"]);
			}
			if($result) { $response = "Message sent."; }
		}
	}
}
include_once("index.php");
