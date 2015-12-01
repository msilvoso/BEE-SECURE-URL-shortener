<!DOCTYPE html>
<html>
	<title>BEE SECURE URL shortener</title>
	<meta name="robots" content="noindex, nofollow">
</html>
<body>
	<a href="export.php">Export database in CSV format</a>
	<form method="post" action="shorten.php" id="shortener">
		<label for="longurl">URL to shorten</label> <input type="text" size="100" name="longurl" id="longurl"><br/> 
		<label for="shorturl">Desired short url domain/something or empty</label> <input type="text" name="shorturl" id="shorturl"><br/>
		<input type="submit" value="Shorten">
	</form>
	<p id="result"></p>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript">
	$(function () {
		$('#shortener').submit(function () {
			$('#result').html('<img src="ajax-loader.gif"/>');
			$.ajax({
				type: 'POST',
				data: {
					longurl: $('#longurl').val(),
					shorturl: $('#shorturl').val()
				},
				url: 'shorten.php', 
				complete: function (XMLHttpRequest, textStatus) {
					result=XMLHttpRequest.responseText;
					if (result.substring(0,5)=='ERROR') {
						result='<span style="color:red;">'+result+'</span>';
					} else {
						result='Short URL: <span style="color:green;">'+result+'</span>';
					}
					$('#result').html(result);
				}
			});
			return false;
		});
	});
	</script>
	</body>
</html>
