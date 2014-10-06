<?php
	if (!isset($folder)) exit();
	$article = json_decode(file_get_contents("contents.json"));
	$title = $article->title;
	$author = $article->author;
	$date = $article->date;
	$articletext = $article->text;
	$img = $article->img;
	$summary = $article->summary;
	$keywords = $article->keywords;
?>

<?php if (!isset($headerfolder)) $headerfolder = ''; require_once($headerfolder."header.php"); ?>

<div class="content">
	<h3><?php echo $title; ?></h3>
	<div class="info">By <?php echo $author; ?> on <? echo $date; ?></div>
	<br />
	<div class="fb-like" data-href="http://theboola.com/article/<?php echo $folder; ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
	<br />
	<br />
	<div class="articletext">
		<?php echo $articletext; ?>
	</div>
	<br />
	<br />
	<?php
		$Bios->addBio($author);
	?>
	<div class="fb-like" data-href="http://theboola.com/article/<?php echo $folder; ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
	<br /><br />
	<div id="disqus_thread"></div>
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'theboola'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
</div>