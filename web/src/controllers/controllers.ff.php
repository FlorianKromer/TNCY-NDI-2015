<?php

use Silex\Provider\FormServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



//Acceuil
$app->get('/', function () use ($app) {
    $sql = "SELECT * FROM Crise";
    $crises = $app['db']->fetchAll($sql);
    //var_dump($crises);
    
    return $app['twig']->render(VERSION.'accueil.twig', array('crises' => $crises));

})->bind('Accueil');

$app->error(function (\Exception $e, $code) use ($app) {
    return $app['twig']->render(VERSION.'error.twig', array('code' => $code));
});
