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


//ETAPE 6 : UN FORMULAIRE
$app->match('/modification_crise/{id}', function (Request $request,$id) use ($app) {
    // some default data for when the form is displayed the first time
	
	$id;
	$select = "Select  * from  Crise inner join GrandActeur on Crise.idAuteur =  GrandActeur.idGrandActeur  where idCrise= ?";
	$psel = $app['db']->fetchAssoc($select, array($id));
		
	
    $data = array(
        'name' => $psel['nomGrandActeur'],
		'titre' => 'Titre de la crise',
        'type' => 'Type de crise',
        'description' => $psel['description'],
		
		'date' => $psel['dateFin'],
		'latitude' => 'latitude du lieu de crise',
		'longitude' => 'longitude du lieu de crise',
		'dateFin' => 'Date de fin',
		'etat' => '1'
    );

    $form = $app['form.factory']->createBuilder('form', $data)
        ->add('name')
		->add('titre')
		->add('type')
		->add('description','textarea')
		->add('date')
		->add('dateFin')
		->add('longitude')
		->add('latitude')
		->	add('etat')
		
		

        
        
        
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
		
		$sql = "Update Crise set titre = ?, description = ?, latitude = ?, longitude = ?, dateDebut = ?, dateFin = ?, idEtat = ? ,idAuteur = ? where id = $id";
		
		$post = $app['db']->executeUpdate($sql, array( $data["titre"], $data["description"], $data["latitude"],$data["longitude"],$data["date"],$data["dateFin"],$data["etat"],$posttemp['idGrandActeur']));
		
        // redirect somewhere
        return $app->redirect('modification_crise',301);
    }

    // display the form
    return $app['twig']->render(VERSION.'modification_crise.twig', array('form' => $form->createView()));
})
->bind('modification_crise');

