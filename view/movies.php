<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Movies</title>
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
      <div class="jumbotron" style="margin-top:20px;">
        <h1>Movies</h1>
        <hr>
		<table class="table table-striped">
			<tr>
				<th>Id</th>
				<th>Title</th>
				<th>Genre</th>
				<th>Length</th>
				<th>IMDB</th>
			</tr>
			<?php
			foreach($movies as $movie){
				echo "<tr>";
				echo "<td>".$movie['id']."</td>";
				echo "<td>".$movie['title']."</td>";
				echo "<td>".$movie['genre']."</td>";
				echo "<td>".$movie['length']."</td>";
				echo "<td><a href='".$movie['imdb']."'>IMDB</a></td>";
				echo "</tr>";
			}
			?>
		</table>
      </div>
    </div> <!-- /container -->
  </body>
</html>
