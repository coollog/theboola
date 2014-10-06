<?php
	require_once('error.php');
	header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	if (!isset($headerfolder)) $headerfolder = '';
	require_once('ibios.php');
?>

<link rel="shortcut icon" href="<?php echo $headerfolder; ?>icon.png">
<?php
	if (isset($article)) {
?>
<title>The Boola - <?php echo $title; ?></title>
<meta name="news_keywords" content="<?php echo $keywords; ?>">
<meta name="author" content="<?php echo $author; ?>">
<meta property="og:title" content="<?php echo $title; ?>" />
<meta property="og:type" content="article" />
<meta property="og:url" content="http://theboola.com/article/<?php echo $folder; ?>" />
<meta property="og:image" content="<?php echo $img; ?>" />
<meta property="og:description" content="<?php echo $summary; ?>" />
<?php
	} else {
?>
<title>The Boola</title>
<meta property="og:title" content="The Boola" />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://theboola.com" />
<meta property="og:image" content="http://theboola.com/logo.png" />
<meta property="og:description" content="An alternative news source that aims to inform and entertain Yale students with simplistic and easy to share online content." />
<?php
	}
?>

<meta name="description" content="An alternative news source that aims to inform and entertain Yale students with simplistic and easy to share online content.">

<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic|Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link href='<?php echo $headerfolder; ?>main.css' rel='stylesheet' type='text/css'>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script src="<?php echo $headerfolder; ?>main.js"></script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=642157445814007";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-10510072-3', 'theboola.com');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');
</script>

<?php
	function addSidebar($headerfolder, $folder) {
		$article = json_decode(file_get_contents($headerfolder."article/$folder/contents.json"));
		$title = $article->title;
?>
		<a class="menu-article menu-link" href="<?php echo $headerfolder; ?>article/<?php echo $folder; ?>/"><?php echo $title; ?></a>
<?php
	}
?>

<div class="sidebar">
	<div class="sidebarin">
		<div class="logo"><!--The<div class="logomain">Boola</div>--></div>
		<div class="dropdown"></div>
		<div class="menu">
			<a class="menu-item menu-link" href="<?php echo $headerfolder; ?>about.php">About</a>
			<a class="menu-item menu-link" href="<?php echo $headerfolder; ?>team.php">The Team</a>
			<br />
			<a class="menu-cat menu-link" href="<?php echo $headerfolder; ?>.">Articles</a>
				<?php //addSidebar($headerfolder, 'Bulldog-Days-What-I-Wish-I-Hadnt-Known'); ?>
				<?php //addSidebar($headerfolder, '15-Things-I-Wish-I-Had-Known-About-Bulldog-Days'); ?>
				<?php //addSidebar($headerfolder, '14-Ways-to-be-Annoying-in-Section'); ?>
				<?php //addSidebar($headerfolder, '8-WTF-Pieces-of-Art-at-Yale'); ?>
				<?php //addSidebar($headerfolder, 'How-to-Spend-Your-Summer-at-Yale'); ?>
				<?php //addSidebar($headerfolder, '14-Signs-Youre-a-CompSci-Major'); ?>
				<?php //addSidebar($headerfolder, 'Are-You-a-Payne-Whitney-GymRat'); ?>
				<?php //addSidebar($headerfolder, '20-Comfort-Foods-All-Yalies-Love'); ?>
				<?php //addSidebar($headerfolder, '8-Signs-You-Went-to-a-Boarding-School'); ?>
				<?php //addSidebar($headerfolder, 'A-Friday-Night-in-New-Haven'); ?>
				<?php //addSidebar($headerfolder, '6-Fun-New-Haven-Dining-Options'); ?>
				<?php //addSidebar($headerfolder, 'Dos-and-Donts-of-Dating-at-Yale'); ?>
				<?php //addSidebar($headerfolder, '5-Steps-to-Your-Dream-Beach-Body'); ?>
				<?php //addSidebar($headerfolder, '8-Studying-Tips-From-Phi-Beta-Kappa'); ?>
				<?php //addSidebar($headerfolder, '5-Apps-That-Should-Be-A-Thing-But-Arent'); ?>
		</div>
	</div>
</div>
<div class="fb-like-box" data-href="https://www.facebook.com/TheBoolaYale" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="false" data-show-border="false" style="position: fixed; bottom: 1em; left: 1em;"></div>
<!--<div class="fb-like" data-href="http://theboola.com" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true" style="position: fixed; bottom: 1em; left: 1em;"></div>-->
<div class="alert">This is our old website. If you are seeing this message, your internet provider has not received our new location. The update should happen within 24 hours.</div>