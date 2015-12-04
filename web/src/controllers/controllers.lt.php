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
		
		'date' => 'Date début crise YYYY-MM-DD',
		'latitude' => 'latitude du lieu de crise',
		'longitude' => 'longitude du lieu de crise'
    );

    $form = $app['form.factory']->createBuilder('form', $data)
        ->add('name')
		->add('titre')
		->add('type')
		->add('description','textarea')
		->add('date')
		->add('longitude')
		->add('latitude')
		
        
        
        
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        $data = $form->getData();
		$data["name"];
		var_dump($data);
		
		//die();
        // do something with the data
		$app['session']->getFlashBag()->add('message', 'Merci pour votre message '.$data["name"]);
		
		//todo : insertion dans la base de données
	
		$temp = "Select idGrandActeur from GrandActeur where nomGrandActeur= ?";
		$posttemp = $app['db']->fetchAssoc($temp, array( $data["name"]));
		
		$sql = "INSERT INTO Crise (titre, description, latitude,longitude,rayon,dateDebut,dateFin,idEtat,idAuteur) VALUE (?,?,?,?,200,?,null,1,?)";
		
		$post = $app['db']->executeUpdate($sql, array( $data["titre"], $data["description"], $data["latitude"],$data["longitude"],$data["date"],$posttemp['idGrandActeur']));
		
        // redirect somewhere
        return $app->redirect('creation_crise',301);
    }

    // display the form
    return $app['twig']->render(VERSION.'creation_crise.twig', array('form' => $form->createView()));
})
->bind('creation_crise');

