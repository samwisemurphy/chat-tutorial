<?php

set_error_handler('chatErrorHandler', E_ALL );


// The NUMBER is the designated error handler. The TEXT is the message of the error
// The FILE is where your getting the error from
// The LINE is where the error is occuiring on that file


function chatErrorHandler($number, $text, $theFile, $theLine) {
	if(ob_get_length()) ob_clean();
//  Clears something ...
									// chr(10) Means go to a new line
	$errorMessage = "Error: " . $number . chr(10) . 
					"Message: " . $text . chr(10) . 
					"File: " . $theFile . chr(10) . 
					"Error: " . $theLine; 

	echo $errorMessage;
	exit;
}	


?>