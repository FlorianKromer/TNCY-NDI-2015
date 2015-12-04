<?php

use Silex\Provider\FormServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// FACEBOOK
$app->get('/facebook', function () use ($app) {

	$config = array();
	$config['app_id'] = '472992356218313';
	$config['app_secret'] = '23c200948c2e38889801aa075d1952eb';
	$config['fileUpload'] = false;
	
	$fb = new Facebook\Facebook($config);
	 
	$params = array(
		"access_token" => "CAAGuLx1ftckBADt0DUpTydLY1sVoZCB8aAXu7HkZCey4ZCZCjEtgugBkjB7BFQPVIreXIyShS8JDRcLl2rp13oyWCtRxoikVN6XerZC1Fk1XtYrw5iZAwL9T4Hc1eFhjjZBrVeSods5FSZBYcR5YHp6ZAec0zikgZCGmgYXyLmMWsVBwefAwMgCUuYGxX7dHZCBeYfcsEIPpTqvbAZDZD",
		"message" => "Here is a blog post about auto posting on Facebook using PHP #php #facebook",
		"link" => "http://www.feelsecure.com",
		"picture" => "",
		"name" => "How to Auto Post on Facebook with PHP",
		"caption" => "http://www.feelsecure.com",
		"description" => "Automatically post on Facebook with PHP using Facebook PHP SDK. How to create a Facebook app. Obtain and extend Facebook access tokens. Cron automation."
	);
	
	try {
		$ret = $fb->post('/1115058661893472/feed', $params);
		echo 'Successfully posted to Facebook';
	} catch(Exception $e) {
		echo $e->getMessage();
	}
    
    return $app['twig']->render(VERSION.'api-requests.twig', array());

})->bind('API');
