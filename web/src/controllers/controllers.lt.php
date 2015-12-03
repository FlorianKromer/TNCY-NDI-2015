<?php

use Silex\Provider\FormServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



//ETAPE 6 : UN FORMULAIRE
$app->match('/creation_crise', function (Request $request) use ($app) {
    // some default data for when the form is displayed the first time
    $data = array(
        'name' => 'Your name',
		'titre' => 'Titre de la crise',
        'type' => 'Type de crise',
        'description' => 'Description de la crise',
		'message' => 'Message à faire passer ',
		'date' => 'Date début crise JJ/MM/YYYY',
		'latitude' => 'latitude du lieu de crise',
		'longitude' => 'longitude du lieu de crise'
    );

    $form = $app['form.factory']->createBuilder('form', $data)
        ->add('name')
		->add('titre')
		->add('type')
		->add('message','textarea')
		->add('date')
		->add('longitude')
		->add('latitude')
		
        
        
        
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        $data = $form->getData();
		$data["name"];
		var_dump($data);
		
		die();
        // do something with the data
		$app['session']->getFlashBag()->add('message', 'Merci pour votre message '.$data["name"]);
		
		//todo : insertion dans la base de données
		$sql = "Insert INTO "
		
        // redirect somewhere
        return $app->redirect('contact',301);
    }

    // display the form
    return $app['twig']->render(VERSION.'creation_crise.twig', array('form' => $form->createView()));
})
->bind('Contact');

