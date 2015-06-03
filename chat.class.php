<?php 
require_once('config.php');
require_once('error_handler.php');

class Chat {

	private $mysqli;

	// Constructor open database connection 

	function __construct() {
		$this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	}

	// Destrcutor closes database connection 
	function __destruct() {
		$this->mysqli->close();
	}

	// Truncates(empties) the table contaiting all messages

	public function deleteAllMessages() {
		$query = 'TRUNCATE TABLE chat'; // Query is built and stored
		$result = $this->mysqli->query($query); // Query is then exectuted
	}

	// Function takes the user who is posting the message and the message
	public function postNewMessage($user_name, $message, $colour) {
		$user_name = $this->mysqli->real_escape_string($user_name); // real_escape_string prevents myslqi injection
		$message = $this->mysqli->real_escape_string($message); // real_escape_string prevents myslqi injection
		$colour = $this->mysqli->real_escape_string($colour); // real_escape_string prevents myslqi injection

		$query = 'INSERT INTO chat (posted_on, user_name, message, colour)' . 
		'VALUES (
		NOW(),
		"' . $user_name . '",
		"' . $message . '",
		"' . $colour . '" ');
		$result = $this->mysqli->query($query);	

	}	

	// Get new messages from database
	public function getNewMessages($id = 0) { // By default we query the database for all the avaliable messages
		$id = $this->mysqli->real_escape_string($id);
		if($id > 0) {
			$query = 
			'SELECT message_id, user_name, message, colour, DATE_FORMAT(posted_on, "%H:%i:%s")
			AS posted_on FROM chat WHERE message_id > ' // This query only returns the new messages if you have been in the chatroom before
			. $id . 'ORDER BY message_id ASC ';

		} else {
			$query = // First time in the chatroom only the first 50 messages are loaded
			'SELECT message_id, user_name, message, colour, posted_on FROM (SELECT chat ORDER BY message_id DESC LIMIT 50) AS Last50
			ORDER BY message_id ASC';
		}

		$result = $this->mysqli->query($query);

		// XML Response  
							// Beginning of XML request being stored into a variable
		$response = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
		$response .= '<response>';

		$response .= $this->isDatabaseCleared($id); // produces tags that says whether the database been cleared <clear> true </clear>

		if($result->num_rows) {		// If 0 the code won't run. If there are new messages the conditional will run
			while($row = $reuslt->fetch_array(MYSQLI_ASSOC)) { // Take the results set (messages). Allows us to use specific keys
				$id = $row['message_id'];
				$colour = $row['colour'];
				$userName = $row['user_name'];
				$time = $row['posted_on'];
				$message = $row['message'];

				$response .= '<id>' . $id . '</id>' . 
							 '<colour>' . $colour . '</colour>' . 
							 '<time>' . $time . '</time>' . 
							 '<name>' . $userName . '</name>' . 
							 '<messages>' . $message . '</messages>';
			}
			$result->close(); // Closes the database connection (good practice)
		}
		$response .= '</response>';
		return $response;	//XML file then returned 
	}

	private function isDatabaseCleared($id) {		// This will be the last $id which reached the client
		if($id > 0) {
			$check_clear = 'SELECT count(*) old FROM chat WHERE message_id <=' . $id; // Count all the messages that are equal or less to the $id we passed in
			$result = $this->mysqli->guery($check_clear);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			if($row['old']) == 0  {
				return  '<clear>true</clear>'; // Means there are no messages in the table
			}
		}
		return '<clear>false</clear>';		// The table still has messages in it
	} 

}




















?>