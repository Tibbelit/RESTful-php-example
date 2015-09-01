<?php
	/*
		Configure database
	*/
	require_once 'lib/medoo.min.php';
	$db = new medoo([
		'database_type' => 'mysql',
		'database_name' => 'movies',
		'server' => 'localhost',
		'username' => 'test',
		'password' => '',
		'charset' => 'utf8'
	]);
	
	/*
		Initialize the app
	*/
	require 'vendor/autoload.php';
	$app = new \Slim\Slim(array(
		'debug' => true,
		'templates.path' => 'view',
	));

    /*
        Return index page
    */
    $app->get('/', function () use ($app, $db) {
        $app->response->setStatus(200);
		$app->response->headers->set('Content-Type', 'text/html');
        $movies = $db->select("movie", "*", ["ORDER" => 'id DESC']);
		$app->render('index.php', array("movie" => $movies[0], "movies" => $movies));
    });

	/*
		Returns all moveis
	*/
	$app->get('/movies', function () use ($app, $db) {
		$app->response->setStatus(200);
        
        $movies = $db->select("movie", "*");
        if($app->request()->get('format') == "json"  or $app->request->headers->get('ACCEPT') == "application/json"){
            $app->response->headers->set('Content-Type', 'application/json');
            $movies = array("movies" => $movies);
            echo json_encode($movies);
        }else if($app->request()->get('format') == "xml" or $app->request->headers->get('ACCEPT') == "application/xml"){
            $app->response->headers->set('Content-Type', 'application/xml');
            // Creating object of SimpleXMLElement
            $xml_data = new SimpleXMLElement('<?xml version="1.0"?><movies></movies>');
            // Function call to convert array to xml
            array_to_xml($movies,$xml_data);
            echo $xml_data->asXML();
        }else{
            $app->response->headers->set('Content-Type', 'text/html');
            $app->render('movies.php', array("movies" => $movies));
        }
	});

	/*
		Returns a movie
	*/
	$app->get('/movies/:id', function ($id) use ($app, $db) {
		$app->response->setStatus(200);
		
        $movie = $db->select("movie", "*", ["id[=]" => $id]);
        if($app->request()->get('format') == "json"  or $app->request->headers->get('ACCEPT') == "application/json"){
            $app->response->headers->set('Content-Type', 'application/json');
            $movie = array("movie" => $movie[0]);
            echo json_encode($movie);
        }else if($app->request()->get('format') == "xml" or $app->request->headers->get('ACCEPT') == "application/xml"){
            $app->response->headers->set('Content-Type', 'application/xml');
            // Creating object of SimpleXMLElement
            $xml_data = new SimpleXMLElement('<?xml version="1.0"?><movie></movie>');
            // Function call to convert array to xml
            array_to_xml($movie[0],$xml_data);
            echo $xml_data->asXML();
        }else{
            $app->response->headers->set('Content-Type', 'text/html');
            $app->render('movie.php', array("movie" => $movie[0]));
        }
	});

	/*
		Creates a new movie
	*/
	$app->post('/movies', function () use ($app, $db) {
		$data = $app->request->post();
        $movie = $db->insert("movie", $data);
        if($movie){
            $app->response->setStatus(201);
            $movie = $db->select("movie", "*", ["id[=]" => $movie]);
            if($app->request()->get('format') == "xml" or $app->request->headers->get('ACCEPT') == "application/xml"){
                $app->response->headers->set('Content-Type', 'application/xml');
                // Creating object of SimpleXMLElement
                $xml_data = new SimpleXMLElement('<?xml version="1.0"?><movie></movie>');
                // Function call to convert array to xml
                array_to_xml($movie[0],$xml_data);
                echo $xml_data->asXML();
            }else{
                $app->response->headers->set('Content-Type', 'application/json');
                $movie = array("movie" => $movie[0]);
                echo json_encode($movie);
            }
        }else{
            /*
                Error
            */
            $app->response->setStatus(400);
            $error = array(
                "message" => "Something went wrong"
            );
            if($app->request()->get('format') == "xml" or $app->request->headers->get('ACCEPT') == "application/xml"){
                $app->response->headers->set('Content-Type', 'application/xml');
                // Creating object of SimpleXMLElement
                $xml_data = new SimpleXMLElement('<?xml version="1.0"?><error></error>');
                // Function call to convert array to xml
                array_to_xml($error,$xml_data);
                echo $xml_data->asXML();
            }else{
                $app->response->headers->set('Content-Type', 'application/json');
                $movie = array("error" => $error);
                echo json_encode($error);
            }
        }
	});

	/*
		Updates a movie
	*/
	$app->put('/movies/:id', function ($id) use ($app, $db) {
		$data = $app->request->put();
        unset($data['_METHOD']);
        $movie = $db->update("movie", $data, ["id[=]" => $id]);
        if($movie){
            $app->response->setStatus(200);
            $movie = $db->select("movie", "*", ["id[=]" => $id]);
            if($app->request()->get('format') == "xml" or $app->request->headers->get('ACCEPT') == "application/xml"){
                $app->response->headers->set('Content-Type', 'application/xml');
                // Creating object of SimpleXMLElement
                $xml_data = new SimpleXMLElement('<?xml version="1.0"?><movie></movie>');
                // Function call to convert array to xml
                array_to_xml($movie[0],$xml_data);
                echo $xml_data->asXML();
            }else{
                $app->response->headers->set('Content-Type', 'application/json');
                $movie = array("movie" => $movie[0]);
                echo json_encode($movie);
            }
        }else{
            /*
                Error
            */
            $app->response->setStatus(400);
            $error = array(
                "message" => "Something went wrong"
            );
            if($app->request()->get('format') == "xml" or $app->request->headers->get('ACCEPT') == "application/xml"){
                $app->response->headers->set('Content-Type', 'application/xml');
                // Creating object of SimpleXMLElement
                $xml_data = new SimpleXMLElement('<?xml version="1.0"?><error></error>');
                // Function call to convert array to xml
                array_to_xml($error,$xml_data);
                echo $xml_data->asXML();
            }else{
                $app->response->headers->set('Content-Type', 'application/json');
                $movie = array("error" => $error);
                echo json_encode($error);
            }
        }
	});

	/*
		Deletes a movie
	*/
	$app->delete('/movies/:id', function ($id) use ($app, $db) {
		$movie = $db->delete("movie", ["id[=]" => $id]);
        if($movie){
            $app->response->setStatus(200);
            if($app->request()->get('format') == "xml" or $app->request->headers->get('ACCEPT') == "application/xml"){
                $app->response->headers->set('Content-Type', 'application/xml');
                // Creating object of SimpleXMLElement
                $xml_data = new SimpleXMLElement('<?xml version="1.0"?><success></success>');
                // Function call to convert array to xml
                $success = [];
                $success['success'] = "true";
                array_to_xml($success,$xml_data);
                echo $xml_data->asXML();
            }else{
                $app->response->headers->set('Content-Type', 'application/json');
                $movie = array("success" => true);
                echo json_encode($movie);
            }
        }else{
            /*
                Error
            */
            $app->response->setStatus(400);
            $error = [];
            $error['message'] = "Something went wrong";
            if($app->request()->get('format') == "xml" or $app->request->headers->get('ACCEPT') == "application/xml"){
                $app->response->headers->set('Content-Type', 'application/xml');
                // Creating object of SimpleXMLElement
                $xml_data = new SimpleXMLElement('<?xml version="1.0"?><error></error>');
                // Function call to convert array to xml
                array_to_xml($error,$xml_data);
                echo $xml_data->asXML();
            }else{
                $app->response->headers->set('Content-Type', 'application/json');
                $movie = array("error" => $error);
                echo json_encode($error);
            }
        }
	});
	
	$app->run();

    /*
        Extra functions
    */
    function array_to_xml( $data, &$xml_data ) {
        foreach( $data as $key => $value ) {
            if( is_array($value) ) {
                if( is_numeric($key) ){
                    $key = 'movie'; //dealing with <0/>..<n/> issues
                }
                $subnode = $xml_data->addChild($key);
                array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key",htmlspecialchars("$value"));
            }
         }
    }
?>