<?php if (!isset($headerfolder)) $headerfolder = ''; require_once($headerfolder."header.php"); ?>

<script>
	$(function() {
		$('.joinus').submit(function() {
			$(this).ajaxSubmit({target: '.joinusresult'});
			$('.joinusresult').html('<img src="loading.gif" />');
			return false;
		});
		$('input[type=email]').bind('enterKey', function(e) {
			$('.joinus').submit();
		}).keyup(function(e) {
			if (e.keyCode == 13) {
				$(this).trigger("enterKey");
			}
		});
	});
</script>
<div class="content">
	<div class="text" style="text-align: center;">
		<br />
		The Boola is an online publication that targets the interests of &hellip; you.
		<br /><br />
		We promise to write about things that relate to your everyday life, whether that&rsquo;s food, school, finances, fashion, you name it. No reviews on hipster bands. No sociopolitical analysis of foreign countries. No academic articles on microscopic molecules.
		<br /><br />
		Not that those aren&rsquo;t important; it&rsquo;s just not us.
		<br /><br />
		Our articles are short, easy-to-read, personal. We make it easy for you to take a break from your busy life to smile, to laugh, or learn something new.   
		<br /><br />
		If you would like to write for us, email <a href="mailto:diane.kim@yale.edu">diane.kim@yale.edu</a> and/or <a href="mailto:qingyang.chen@yale.edu">qingyang.chen@yale.edu</a>. Anyone is welcome to join the team!
		<br /><br />
		Join our mailing list! Type your email below.
		<div class="joinusresult"></div>
		<form class="joinus" action="joinus.php" method="post"><input type="email" name="email" placeholder="Email Address" /></form>
	</div>
</div>