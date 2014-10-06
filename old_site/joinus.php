<?php
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			function sendmail($to, $subject, $message, $from) {
				mail($to, $subject, "
					<html>
						<head>
							<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />
						</head>
						<body>
							$message
						</body>
					</html>
				", "From: $from\r\nReply-To: $from\r\nMIME-Version: 1.0\r\nContent-type: text/html; charset: utf8\r\n");
			}
			sendmail('qingyang.chen@yale.edu, diane.kim@yale.edu', "New The Boola mailing list subscription!", "
				This is an automated message from the submission system for the Join Us form on the The Boola website.
				<br />New email: $email", 'qingyang.chen@yale.edu');
			sendmail($email, "Subscription to The Boola newsletter!", "
				Thanks for subscribing to The Boola's weekly newsletter!", 'qingyang.chen@yale.edu');
			echo '<h3>Thank you!</h3>';
		} else {
			echo 'Invalid email address!';
		}
	}
?>