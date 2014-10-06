<?php
	require_once('error.php');
	$fixtext = true;
	function clean($str) {
		return htmlentities(utf8_encode($str));
	}
	function cleansmart($string) { 
		$search = array(chr(145), 
						chr(146), 
						chr(147), 
						chr(148), 
						chr(151),
						'...');
		$replace = array('&lsquo;', 
						 '&rsquo;', 
						 '&ldquo;', 
						 '&rdquo;', 
						 '&mdash;',
						 '&hellip;'); 
		return nl2br(utf8_encode(str_replace($search, $replace, $string))); 
	}
	function br2nl($string) {
		return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
	}
	function reversecleansmart($string) {
		$replace = array(chr(145), 
						chr(146), 
						chr(147), 
						chr(148), 
						chr(151),
						'...',
						"");
		$search = array('&lsquo;', 
						 '&rsquo;', 
						 '&ldquo;', 
						 '&rdquo;', 
						 '&mdash;',
						 '&helip;',
						 "\r\n");
		return str_replace($search, $replace, br2nl($string));
	}
	
	$title = $author = $articletext = $img = $summary = $keywords = "";
	$date = date('F j, Y');
	
	if (isset($_POST['pass'])) {
		$pass = $_POST['pass'];
		
		$title = clean($_POST['title']);
		$author = clean($_POST['author']);
		$date = clean($_POST['date']);
		$img = $_POST['img'];
		$articletext = $_POST['text'];
		$summary = $_POST['summary'];
		$keywords = clean($_POST['keywords']);
		
		if (	strlen($title) > 0 &&
				strlen($author) > 0 &&
				strlen($date) > 0 &&
				strlen($articletext) > 0 &&
				strlen($img) > 0 &&
				strlen($summary) > 0 &&
				strlen($keywords) > 0) {
				
			$folder = str_replace(" ", "-", preg_replace("/[^0-9a-zA-Z ]/", "", $title));
			$dir = "article/$folder";
			
			if (!is_dir($dir)) { // New article
				if ($pass == 'boolastaff') {
					mkdir($dir);
					$articletext = cleansmart($_POST['text']);
					$summary = cleansmart($_POST['summary']);
						
					$contents = array(
						'title' => $title,
						'author' => $author,
						'date' => $date,
						'text' => $articletext,
						'img' => $img,
						'summary' => $summary,
						'keywords' => $keywords);
					file_put_contents("article/$folder/index.php", '<?php
						$folder = "'.$folder.'";
						$headerfolder = "../../";
						require_once("../../article.php");
					?>');
					file_put_contents("article/$folder/contents.json", json_encode($contents));
					
					$articletext = reversecleansmart($articletext);
					$summary = reversecleansmart($summary);
					
					echo 'Article successfully submitted!';
				} else {
					echo 'Passcode incorrect!';
				}
			} else {
				if ($pass == 'boolastaffedit') { // Editing article
					$articletext = cleansmart($_POST['text']);
					$summary = cleansmart($_POST['summary']);
						
					$contents = array(
						'title' => $title,
						'author' => $author,
						'date' => $date,
						'text' => $articletext,
						'img' => $img,
						'summary' => $summary,
						'keywords' => $keywords);
					file_put_contents("article/$folder/index.php", '<?php
						$folder = "'.$folder.'";
						$headerfolder = "../../";
						require_once("../../article.php");
					?>');
					file_put_contents("article/$folder/contents.json", json_encode($contents));
					
					$articletext = reversecleansmart($articletext);
					$summary = reversecleansmart($summary);
				
					echo 'Article successfully editted!';
				} else {
					echo 'Article title already exists!';
				}
			}
		} else {
			echo 'All fields must not be empty!';
		}
	}
	
	if (isset($_POST['article'])) {
		// Load existing article
		$folder = $_POST['article'];
		$dir = "article/$folder";
		if (is_dir($dir)) {
			$article = json_decode(file_get_contents("$dir/contents.json"));
			$title = $article->title;
			$author = $article->author;
			$date = $article->date;
			$articletext = reversecleansmart($article->text);
			$img = $article->img;
			$summary = reversecleansmart($article->summary);
			$keywords = $article->keywords;
		}
	}
?>

<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700|Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<style>
	body {
		margin: 10px;
		font-family: 'Lato', sans-serif;
	}
	input, select {
		display: block;
		width: 400px;
		border: 1px solid black;
		height: 40px;
		margin: 10px 0;
		padding: 0 10px;
		font-size: 20px;
		line-height: 40px;
	}
	input[type=submit] {
		width: 200px;
		background: white;
	}
	textarea {
		display: block;
		width: 600px;
		height: 400px;
		border: 1px solid black;
		margin: 10px 0;
		padding: 10px;
		font-size: 14px;
		line-height: 20px;
	}
	textarea[name=summary] {
		height: 100px;
	}
	h1 {
		margin: 10px 0;
		font-size: 30px;
		line-height: 40px;
	}
	input.tool {
		display: inline-block;
		width: 200px;
	}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script>
	function insertAtCaret(element, text) {
		if (document.selection) {
			element.focus();
			var sel = document.selection.createRange();
			sel.text = text;
			element.focus();
		} else if (element.selectionStart || element.selectionStart === 0) {
			var startPos = element.selectionStart;
			var endPos = element.selectionEnd;
			var scrollTop = element.scrollTop;
			element.value = element.value.substring(0, startPos) + text + element.value.substring(endPos, element.value.length);
			element.focus();
			element.selectionStart = startPos + text.length;
			element.selectionEnd = startPos + text.length;
			element.scrollTop = scrollTop;
		} else {
			element.value += text;
			element.focus();
		}
	}
	function getInputSelection(el) {
		var start = 0, end = 0, normalizedValue, range,
			textInputRange, len, endRange;

		if (typeof el.selectionStart == "number" && typeof el.selectionEnd == "number") {
			start = el.selectionStart;
			end = el.selectionEnd;
		} else {
			range = document.selection.createRange();

			if (range && range.parentElement() == el) {
				len = el.value.length;
				normalizedValue = el.value.replace(/\r\n/g, "\n");

				// Create a working TextRange that lives only in the input
				textInputRange = el.createTextRange();
				textInputRange.moveToBookmark(range.getBookmark());

				// Check if the start and end of the selection are at the very end
				// of the input, since moveStart/moveEnd doesn't return what we want
				// in those cases
				endRange = el.createTextRange();
				endRange.collapse(false);

				if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
					start = end = len;
				} else {
					start = -textInputRange.moveStart("character", -len);
					start += normalizedValue.slice(0, start).split("\n").length - 1;

					if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1) {
						end = len;
					} else {
						end = -textInputRange.moveEnd("character", -len);
						end += normalizedValue.slice(0, end).split("\n").length - 1;
					}
				}
			}
		}

		return {
			start: start,
			end: end
		};
	}
	function replaceSelectedText(el, text) {
		var sel = getInputSelection(el), val = el.value;
		el.value = val.slice(0, sel.start) + text + val.slice(sel.end);
	}
	
	
	$(function() {
		$('.addimg').click(function() {
			var url = $('.addimgurl').val();
			insertAtCaret($('textarea[name=text]')[0], "<img src='" + url + "'>");
		});
		$('.wraptag').click(function() {
			var textarea = $('textarea[name=text]')[0];
			var bounds = getInputSelection(textarea);
			var inside = textarea.value.slice(bounds.start, bounds.end);
			var tag = $(this).attr('tag');
			replaceSelectedText(textarea, "<" + tag + ">" + inside + "</" + tag + ">");
		});
	});
</script>

<h1>Load Existing Article</h1>
<form method="post">
	<select name="article">
		<?php
			$dir = scandir('article');
			unset($dir[0]); unset($dir[1]);
			foreach ($dir as $a) {
				echo "<option value='$a'>$a</option>";
			}
		?>
	</select>
	<input type="submit" value="Load" />
</form>

<h1>Submit an Article</h1>
<form method="post">
	<input type="password" name="pass" placeholder="Password" />
	<input type="text" name="title" placeholder="Title" value="<?php echo $title; ?>" />
	<input type="text" name="author" placeholder="Author" value="<?php echo $author; ?>" />
	<input type="text" name="date" placeholder="Date" value="<?php echo $date; ?>" />
	<input type="text" name="img" placeholder="Image URL" value="<?php echo $img; ?>" />
	<textarea name="text" placeholder="Article Body"><?php echo $articletext; ?></textarea>
	<input class="tool addimgurl" type="text" placeholder="URL" /><input class="tool addimg" type="button" value="Insert Image" /><br />
	<input class="tool wraptag" type="button" tag="b" value="Bold" /><input class="tool wraptag" type="button" tag="i" value="Italic" /><br />
	<input class="tool wraptag" type="button" tag="big" value="Big" /><input class="tool wraptag" type="button" tag="small" value="Small" /><br />
	<textarea name="summary" placeholder="Summary"><?php echo $summary; ?></textarea>
	<input type="text" name="keywords" placeholder="Keywords (separated by commas)" value="<?php echo $keywords; ?>" />
	<input type="submit" value="Submit" />
</form>