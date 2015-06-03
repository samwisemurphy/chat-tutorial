<?php
require_once("chat.class.php");
$mode = $_POST['mode'];		
$id = 0;
$chat = new Chat();

if($mode == 'SendAndRetrieveNew') {		//When you want to send and retrieve new messages
	$name = $_POST['name'];
	$message = $_POST['message'];
	$colour = $_POST['colour'];
	$id = $_POST['id'];

	if($name != '' || $message != '' || $colour != '') {
		$chat->postNewMessage($name, $message, $colour);	// Posting the message to the database
	}

} elseif ($mode == 'DeleteAndRetrieveNew') {
	$chat->deleteAllMessages();
} elseif ($mode == 'RetreiveNew') { //Gets the last message_id received from the client
	$id = $_POST['id'];
}

if(ob_get_length()) {
	ob_clean();
}

// Headers are sent to prevent browsers from caching. Caching is when your browser saves things. 
// As we're always getting new information in a chatroom we don't need it to be saved
// These headers stop the browser from trying to cache

header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Content-Type: text/xml');

echo $chat->getNewMessages($id); // this id is the last message tht the client saw. If there are any new messages they then get displayed


?>