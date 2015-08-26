<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Min filmsamling</title>
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        $(document).on("ready", function(){
           $(".format").on("change", function(){
               var adress = $(this).parent().parent().parent().attr("data-adress");
               if($(this).val() == "json"){
                    $(this).parent().parent().parent().attr("action", adress);
               }else{
                    $(this).parent().parent().parent().attr("action", adress+"?format=xml");
               }
           }); 
        
            /*
                Testing out the ACCEPT headers
            */
            $.ajax({
                url: "/movies",
                headers: {
                    Accept : "application/json"
                    // Accept : "application/xml"
                    // Accept : "text/html"
                }
            }).done(function(data){
                console.log(data);
            });
        });
    </script>
  </head>

  <body>

    <div class="container">
      <div class="jumbotron" style="margin-top:20px; overflow:hidden;">
        <h1>Min filmsamling</h1>
        <hr>
          <p>Detta är ett exempel på ett RESTful API för min låtsatsfilmsamling! =) Detta kan man göra:</p>
          <div class="well">
             <table class="table table-striped">
                 <tr>
                     <th>URL</th>
                     <th>HTTP Metod</th>
                     <th>Operation</th>
                 </tr>
                 <tr>
                    <td>/movies</td>
                    <td>GET</td>
                    <td>Returnerar alla filmer</td>
                 </tr>
                 <tr>
                    <td>/movies/:id</td>
                    <td>GET</td>
                    <td>Returnerar filmen med id :id</td>
                 </tr>
                 <tr>
                    <td>/movies</td>
                    <td>POST</td>
                    <td>Lägger till en ny film och returnerar den tillagda filmen</td>
                 </tr>
                 <tr>
                    <td>/movies/:id</td>
                    <td>PUT</td>
                    <td>Uppdaterar filmen med id :id</td>
                 </tr>
                 <tr>
                    <td>/movies/:id</td>
                    <td>DELETE</td>
                    <td>Raderar filmen med id :id</td>
                 </tr>
             </table>
             <p style="font-size:14px;">Genom att lägga till attributet &format=json så returneras alltid JSON-data, t.ex.<br>
             <a href="/movies?format=json">/movies?format=json</a><br>
             eller genom att lägga till &format=xml så returneras alltid XML-data., t.ex.<br>
             <a href="/movies?format=xml">/movies?format=xml</a><br>Annars vid GET-metoder returneras en webbsida med resultaten, t.ex.<br>
             <a href="/movies">/movies</a></p>
          </div>
          <h2>Exempelanvändning av API:t</h2>
          <form method="post" action="/movies" data-adress="/movies">
              <fieldset>
                  <legend>Skapa en ny film</legend>
                  <div class="form-group">
                    <label for="title" class="control-label">Titel</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Titel på film" required>
                  </div>
                  <div class="form-group">
                    <label for="genre" class="control-label">Genre</label>
                    <input type="text" class="form-control" id="genre" name="genre" placeholder="Genre på film" required>
                  </div>
                  <div class="form-group">
                    <label for="length" class="control-label">Speltid</label>
                    <input type="number" class="form-control" id="length" name="length" placeholder="Speltid på film" required>
                  </div>
                  <div class="form-group">
                    <label for="image" class="control-label">Bild</label>
                    <input type="url" class="form-control" id="image" name="image" placeholder="Länk till cover för film" required>
                  </div>
                  <div class="form-group">
                    <label for="imdb" class="control-label">Länk till IMDB</label>
                    <input type="url" class="form-control" id="imdb" name="imdb" placeholder="Länk till filem på IMDB" required>
                  </div>
                  <div class="form-group">
                    <label for="format" class="control-label">Format (som returneras)</label>
                    <select class="form-control format">
                        <option value="json">JSON</option>
                        <option value="xml">XML</option>
                    </select>
                  </div>
                  <input type="submit" class="btn btn-success" value="Spara film">                 
              </fieldset>
          </form>
          <hr>
          <form method="post" action="/movies/<?php echo $movie['id']; ?>" data-adress="/movies/<?php echo $movie['id']; ?>">
              <input type="hidden" name="_METHOD" value="PUT"/>
              <fieldset>
                  <legend>Redigera den <strong>senast inlagda</strong> filmen</legend>
                  <div class="form-group">
                    <label for="title" class="control-label">Titel</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Titel på film" required value="<?php echo $movie['title']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="genre" class="control-label">Genre</label>
                    <input type="text" class="form-control" id="genre" name="genre" placeholder="Genre på film" required value="<?php echo $movie['genre']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="length" class="control-label">Speltid</label>
                    <input type="number" class="form-control" id="length" name="length" placeholder="Speltid på film" required value="<?php echo $movie['length']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="image" class="control-label">Bild</label>
                    <input type="url" class="form-control" id="image" name="image" placeholder="Länk till cover för film" required value="<?php echo $movie['image']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="imdb" class="control-label">Länk till IMDB</label>
                    <input type="url" class="form-control" id="imdb" name="imdb" placeholder="Länk till filem på IMDB" required value="<?php echo $movie['imdb']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="format" class="control-label">Format (som returneras)</label>
                    <select class="form-control format">
                        <option value="json">JSON</option>
                        <option value="xml">XML</option>
                    </select>
                  </div>
                  <input type="submit" class="btn btn-success" value="Spara film">                 
              </fieldset>
          </form>
          <hr>
          <h3>Radera en film</h3>
          <table class="table table-striped">
			<tr>
				<th>Id</th>
				<th>Title</th>
				<th>Genre</th>
				<th>Length</th>
				<th>IMDB</th>
				<th>Radera film</th>
				<th>JSON/XML</th>
			</tr>
			<?php
			foreach($movies as $movie){
				echo "<tr>";
				echo "<td>".$movie['id']."</td>";
				echo "<td>".$movie['title']."</td>";
				echo "<td>".$movie['genre']."</td>";
				echo "<td>".$movie['length']."</td>";
				echo "<td><a href='".$movie['imdb']."'>IMDB</a></td>";
                echo "<td>
                        <form action='/movies/".$movie['id']."?format=json' method='post'>
                            <input type='hidden' name='_METHOD' value='delete'>
                            <input type='submit' class='btn btn-danger' value='Radera (JSON)'>
                        </form>
                    </td>";
                echo "<td>
                        <form action='/movies/".$movie['id']."?format=xml' method='post'>
                            <input type='hidden' name='_METHOD' value='delete'>
                            <input type='submit' class='btn btn-danger' value='Radera (XML)'>
                        </form>
                    </td>";
				echo "</tr>";
			}
			?>
		</table>
      </div>
    </div> <!-- /container -->
  </body>
</html>
