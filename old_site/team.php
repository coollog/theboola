<?php if (!isset($headerfolder)) $headerfolder = ''; require_once($headerfolder."header.php"); ?>

<div class="content">
	<h1>The Team</h1>
	<?php
		$Bios->addBio('diane');
		$Bios->addBio('qingyang');
		$Bios->addBio('karin');
		$Bios->addBio('maggie');
		$Bios->addBio('aryeh');
		$Bios->addBio('austin');
		$Bios->addBio('jenny');
		$Bios->addBio('stephany');
		$Bios->addBio('rebecca');
		$Bios->addBio('brea');
	?>
</div>