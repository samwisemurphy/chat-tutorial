<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Chat</title>
	<link rel="stylesheet" href="chat.css" type="text/css">
	<script type="text/javascript" src="chat.js"></script>
</head>
<body onload="init();">
	<table id="content">
		<tr>
			<td>
				<div id="scroll"></div>
			</td>
			<td id="colourpicker" valign="top">
				<input id="colour" type="hidden" readonly="true" value="#000000">
			</td>
		</tr>
	</table>

	<div>
		<input type="text" id="userName" maxlength="10" size="10" onblur="checkUsername();">
		<input type="text" id="messageBox" maxlength="2000" size="50" onkeydown="handleKey(event)">
		<input type="button" value="Send" onclick="sendMessage();">
		<input type="button" value="Delete All" onclick="deleteAllMessages();">
	</div>
</body>
</html>