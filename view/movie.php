<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Movie: <?php echo $movie['title']; ?></title>
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="jumbotron" style="margin-top:20px; overflow:hidden;">
        <h1><?php echo $movie['title']; ?></h1>
        <hr>
        <div class="col-md-10">
            <?php
			echo "<p><strong>Id:</strong> ".$movie['id']."</td>";
			echo "<p><strong>Genre:</strong> ".$movie['genre']."</p>";
			echo "<p><strong>Speltid:</strong> ".$movie['length']."</p>";
			echo "<p><strong>IMDB:</strong> <a href='".$movie['imdb']."'>IMDB</a></p>";
			?>
		</div>
		<div class="col-md-2">
            <?php
            echo "<img src='".$movie['image']."' alt='poster' style='max-width:100%;'>";
            ?>
		</div>
      </div>
    </div> <!-- /container -->
  </body>
</html>
