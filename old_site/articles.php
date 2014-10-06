<?php 
	if (!isset($headerfolder)) $headerfolder = '';
	require_once($headerfolder."header.php");
	
	function addArticle($folder) {
		$article = json_decode(file_get_contents("article/$folder/contents.json"));
		$title = $article->title;
		$author = $article->author;
		$img = $article->img;
?>
		<a class="article clickable" style="background-image: url('<?php echo $img; ?>');"
			href="article/<?php echo $folder; ?>/">
			<div class="title">
				<?php echo $title; ?>
				<div class="author"><?php echo $author; ?></div>
			</div>
		</a>
<?php
	}
?>

<div class="content" style="padding-top: 6em;">
	<style>
		.content .article:first-of-type {
			width: 600px;
			height: 300px;
			display: block;
			margin: 1em auto;
		}
		.content .article:first-of-type .title {
			font-size: 1.3em;
			font-weight: 700;
			font-family: 'Open Sans', sans-serif;
		}
	</style>
	<!--<h4>April 19, 2014</h4>-->
	<?php addArticle('How-to-Spend-Your-Summer-at-Yale'); ?>
	<?php addArticle('9-Signs-Youre-Obsessed-with-Beyonceacute'); ?>
	<?php addArticle('15-Things-I-Wish-I-Had-Known-On-Bulldog-Days'); ?>
	<?php addArticle('What-I-Wish-I-Hadnt-Known-On-Bulldog-Days'); ?>
	<?php addArticle('14-Ways-to-be-Annoying-in-Section'); ?>
	<?php addArticle('8-WTF-Pieces-of-Art-at-Yale'); ?>
	<?php addArticle('14-Signs-Youre-a-CompSci-Major'); ?>
	<!--<h4>April 7, 2014</h4>-->
	<?php addArticle('A-Friday-Night-in-New-Haven'); ?>
	<?php addArticle('8-Signs-You-Went-to-a-Boarding-School'); ?>
	<?php addArticle('20-Comfort-Foods-All-Yalies-Love'); ?>
	<?php addArticle('Are-You-a-Payne-Whitney-GymRat'); ?>
	<!--<h4>March 24, 2014</h4>-->
	<?php addArticle('6-Fun-New-Haven-Dining-Options'); ?>
	<?php addArticle('Dos-and-Donts-of-Dating-at-Yale'); ?>
	<!--<h4>March 7, 2014</h4>-->
	<?php addArticle('5-Steps-to-Your-Dream-Beach-Body'); ?>
	<!--<h4>February 22, 2014</h4>-->
	<?php addArticle('8-Studying-Tips-From-Phi-Beta-Kappa'); ?>
	<?php addArticle('5-Apps-That-Should-Be-A-Thing-But-Arent'); ?>
</div>