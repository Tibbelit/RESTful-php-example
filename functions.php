<?php

/**
 * Fetch a movie from the database and send a response
 * 
 * @param integer $id The ID of the movie to fetch
 * @param object $app The web application object
 * @param object $db The database object
 */
function fetchMovie($id, $app, $db) {
	$app->response->setStatus ( 200 );
	
	$movie = $db->select ( "movie", "*", [
			"id[=]" => $id
	] );
	if ($app->request ()->get ( 'format' ) == "json" or $app->request->headers->get ( 'ACCEPT' ) == "application/json") {
		$app->response->headers->set ( 'Content-Type', 'application/json' );
		$movie = array (
				"movie" => $movie [0]
		);
		echo json_encode ( $movie );
	} else if ($app->request ()->get ( 'format' ) == "xml" or $app->request->headers->get ( 'ACCEPT' ) == "application/xml") {
		$app->response->headers->set ( 'Content-Type', 'application/xml' );
		// Creating object of SimpleXMLElement
		$xml_data = new SimpleXMLElement ( '<?xml version="1.0"?><movie></movie>' );
		// Function call to convert array to xml
		array_to_xml ( $movie [0], $xml_data );
		echo $xml_data->asXML ();
	} else {
		$app->response->headers->set ( 'Content-Type', 'text/html' );
		$app->render ( 'movie.php', array (
				"movie" => $movie [0]
		) );
	}
}

/**
 * Fetch a list of all movies in the database and send a resoponse
 * 
 * @param object $app The web application object
 * @param object $db The database object
 */
function listAllMovies($app, $db) {
	$app->response->setStatus ( 200 );
	
	$movies = $db->select ( "movie", "*" );
	if ($app->request ()->get ( 'format' ) == "json" or $app->request->headers->get ( 'ACCEPT' ) == "application/json") {
		$app->response->headers->set ( 'Content-Type', 'application/json' );
		$movies = array (
				"movies" => $movies
		);
		echo json_encode ( $movies );
	} else if ($app->request ()->get ( 'format' ) == "xml" or $app->request->headers->get ( 'ACCEPT' ) == "application/xml") {
		$app->response->headers->set ( 'Content-Type', 'application/xml' );
		// Creating object of SimpleXMLElement
		$xml_data = new SimpleXMLElement ( '<?xml version="1.0"?><movies></movies>' );
		// Function call to convert array to xml
		array_to_xml ( $movies, $xml_data );
		echo $xml_data->asXML ();
	} else {
		$app->response->headers->set ( 'Content-Type', 'text/html' );
		$app->render ( 'movies.php', array (
				"movies" => $movies
		) );
	}
}

/**
 * Add a movie to the database and send a response
 * 
 * @param object $app The web application object
 * @param object $db The database object
 */
function addMovie($app, $db) {
	$app->response->setStatus ( 200 );
	
	$data = $app->request->post();
	$movie = $db->insert("movie", $data);
	if($movie){
		$app->response->setStatus(200);
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
}

/**
 * Update a movie in the database
 * 
 * @param integer $id The ID of the movie to fetch
 * @param object $app The web application object
 * @param object $db The database object
 */
function updateMovie($id, $app, $db) {
	$data = $app->request->put ();
	unset ( $data ['_METHOD'] );
	$movie = $db->update ( "movie", $data, [
			"id[=]" => $id
	] );
	if ($movie) {
		$app->response->setStatus ( 200 );
		$movie = $db->select ( "movie", "*", [
				"id[=]" => $id
		] );
		if ($app->request ()->get ( 'format' ) == "xml" or $app->request->headers->get ( 'ACCEPT' ) == "application/xml") {
			$app->response->headers->set ( 'Content-Type', 'application/xml' );
			// Creating object of SimpleXMLElement
			$xml_data = new SimpleXMLElement ( '<?xml version="1.0"?><movie></movie>' );
			// Function call to convert array to xml
			array_to_xml ( $movie [0], $xml_data );
			echo $xml_data->asXML ();
		} else {
			$app->response->headers->set ( 'Content-Type', 'application/json' );
			$movie = array (
					"movie" => $movie [0]
			);
			echo json_encode ( $movie );
		}
	} else {
		/*
		 * Error
		 */
		$app->response->setStatus ( 400 );
		$error = array (
				"message" => "Something went wrong"
		);
		if ($app->request ()->get ( 'format' ) == "xml" or $app->request->headers->get ( 'ACCEPT' ) == "application/xml") {
			$app->response->headers->set ( 'Content-Type', 'application/xml' );
			// Creating object of SimpleXMLElement
			$xml_data = new SimpleXMLElement ( '<?xml version="1.0"?><error></error>' );
			// Function call to convert array to xml
			array_to_xml ( $error, $xml_data );
			echo $xml_data->asXML ();
		} else {
			$app->response->headers->set ( 'Content-Type', 'application/json' );
			$movie = array (
					"error" => $error
			);
			echo json_encode ( $error );
		}
	}
}

/**
 * Delete a movie in the database
 * 
 * @param integer $id The ID of the movie to fetch
 * @param object $app The web application object
 * @param object $db The database object
 */
function deleteMovie($id, $app, $db) {
	$movie = $db->delete ( "movie", [
			"id[=]" => $id
	] );
	if ($movie) {
		$app->response->setStatus ( 200 );
		if ($app->request ()->get ( 'format' ) == "xml" or $app->request->headers->get ( 'ACCEPT' ) == "application/xml") {
			$app->response->headers->set ( 'Content-Type', 'application/xml' );
			// Creating object of SimpleXMLElement
			$xml_data = new SimpleXMLElement ( '<?xml version="1.0"?><success></success>' );
			// Function call to convert array to xml
			$success = [ ];
			$success ['success'] = "true";
			array_to_xml ( $success, $xml_data );
			echo $xml_data->asXML ();
		} else {
			$app->response->headers->set ( 'Content-Type', 'application/json' );
			$movie = array (
					"success" => true
			);
			echo json_encode ( $movie );
		}
	} else {
		/*
		 * Error
		 */
		$app->response->setStatus ( 400 );
		$error = [ ];
		$error ['message'] = "Something went wrong";
		if ($app->request ()->get ( 'format' ) == "xml" or $app->request->headers->get ( 'ACCEPT' ) == "application/xml") {
			$app->response->headers->set ( 'Content-Type', 'application/xml' );
			// Creating object of SimpleXMLElement
			$xml_data = new SimpleXMLElement ( '<?xml version="1.0"?><error></error>' );
			// Function call to convert array to xml
			array_to_xml ( $error, $xml_data );
			echo $xml_data->asXML ();
		} else {
			$app->response->headers->set ( 'Content-Type', 'application/json' );
			$movie = array (
					"error" => $error
			);
			echo json_encode ( $error );
		}
	}
}

/*
 * Extra functions
 */
function array_to_xml($data, &$xml_data) {
	foreach ( $data as $key => $value ) {
		if (is_array ( $value )) {
			if (is_numeric ( $key )) {
				$key = 'movie'; // dealing with <0/>..<n/> issues
			}
			$subnode = $xml_data->addChild ( $key );
			array_to_xml ( $value, $subnode );
		} else {
			$xml_data->addChild ( "$key", htmlspecialchars ( "$value" ) );
		}
	}
}