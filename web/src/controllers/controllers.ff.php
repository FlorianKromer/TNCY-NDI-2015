<?php

use Silex\Provider\FormServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



//Acceuil
$app->get('/', function () use ($app) {
    $sql = "SELECT * FROM crise";
    //$crises = $app['db']->fetchAll($sql);
    $crises = array();
    return $app['twig']->render(VERSION.'accueil.twig', array('crises' => $crises));

})->bind('Accueil');

