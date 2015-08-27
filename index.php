<?php
require_once 'functions.php';

/*
 * Configure database
 */
require_once 'lib/medoo.min.php';
$db = new medoo ( [ 
		'database_type' => 'mysql',
		'database_name' => 'movies',
		'server' => 'localhost',
		'username' => 'test',
		'password' => '',
		'charset' => 'utf8' 
] );

/*
 * Initialize the app
 */
require 'vendor/autoload.php';
$app = new \Slim\Slim ( array (
		'debug' => true,
		'templates.path' => 'view' 
) );

/*
 * Return index page
 */
$app->get ( '/', function () use($app, $db) {
	$app->response->setStatus ( 200 );
	$app->response->headers->set ( 'Content-Type', 'text/html' );
	$movies = $db->select ( "movie", "*", [
			"ORDER" => 'id DESC'
	] );
	$app->render ( 'index.php', array (
			"movie" => $movies [0],
			"movies" => $movies
	) );
} );

/*
 * Returns all movies
 */
$app->get ( '/movies', function () use($app, $db) {
	listAllMovies($app, $db);
} );

/*
 * Returns a movie
 */
$app->get ( '/movies/:id', function ($id) use($app, $db) {
	fetchMovie($id, $app, $db);
} );

/*
 * Creates a new movie
 */
$app->post ( '/movies', function () use($app, $db) {
	addMovie($app, $db);
} );

/*
 * Updates a movie
 */
$app->put ( '/movies/:id', function ($id) use($app, $db) {
	updateMovie($id, $app, $db);
} );

/*
 * Deletes a movie
 */
$app->delete ( '/movies/:id', function ($id) use($app, $db) {
	deleteMovie($id, $app, $db);
} );

$app->run ();
?>