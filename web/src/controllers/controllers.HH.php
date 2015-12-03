<?php

use Silex\Provider\FormServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



//ETAPE 1 : une route
$app->get('/hello', function () {
    return 'Hello!';
});

//ETAPE 2: ROUTE AVEC PARAMETRE
$app->get('/hello/{name}', function ($name) use ($app) {
    return $app['twig']->render(VERSION.'hello.twig', array(
        'name' => $name,
    ));
});

//ETAPE 3: HERITAGE DANS TWIG
$app->get('/coucou/{name}', function ($name) use ($app) {
    return $app['twig']->render(VERSION.'coucou.twig', array(
        'name' => $name,
    ));
});

//ETAPE 4: LE NOMMAGE DES ROUTES
$app->get('/', function () use ($app) {
    return $app['twig']->render(VERSION.'accueil.twig');
})
->bind('Accueil');
$app->get('/infos', function () use ($app) {
    return $app['twig']->render(VERSION.'info.twig');
})
->bind('Info');

//ETAPE 5: UN PEU DE STYLE


//ETAPE 6 : UN FORMULAIRE
$app->match('/contact', function (Request $request) use ($app) {
    // some default data for when the form is displayed the first time
    $data = array(
        'name' => 'Your name',
        'email' => 'Your email',
        'content' => 'Your message'
    );

    $form = $app['form.factory']->createBuilder('form', $data)
        ->add('name')
        ->add('email', 'email', array(
        'attr' => array('placeholder' => 'Email','class'=>''),
        'label' => 'Email'))
        ->add('gender', 'choice', array(
            'choices' => array(1 => 'male', 2 => 'female'),
            'expanded' => true,
        ))
        ->add('content','textarea')
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        $data = $form->getData();

        // do something with the data
		$app['session']->getFlashBag()->add('message', 'Merci pour votre message '.$data["name"]);
        // redirect somewhere
        return $app->redirect('contact',301);
    }

    // display the form
    return $app['twig']->render(VERSION.'contact.twig', array('form' => $form->createView()));
})
->bind('Contact');

//ETAPE 7: BOOTSTRAP


//ETAPE 8 : LA BASE DE DONNEES
$app->get('/blog', function () use ($app) {
    $sql = "SELECT * FROM posts";
    $posts = $app['db']->fetchAll($sql);

    return $app['twig']->render(VERSION.'blog.twig', array('posts' => $posts));

})->bind('Blog');
$app->get('/blog/{id}', function ($id) use ($app) {
    $sql = "SELECT * FROM posts WHERE id = ?";
    $post = $app['db']->fetchAssoc($sql, array((int) $id));

    return $app['twig']->render(VERSION.'blog-detail.twig', array('post' => $post));

})
->bind('Blog-detail');

//ETAPE 6 : ENVOIE DE MAIL
$app->match('/contact2', function (Request $request) use ($app) {
    // some default data for when the form is displayed the first time
    $data = array(
        'name' => 'Your name',
        'email' => '',
        'content' => 'Your message'
    );

    $form = $app['form.factory']->createBuilder('form', $data)
        ->add('name')
        ->add('email', 'email', array(
        'attr' => array('placeholder' => 'Ton Email','class'=>''),
        'label' => 'Email'))
        ->add('gender', 'choice', array(
            'choices' => array(1 => 'male', 2 => 'female'),
            'expanded' => true,
        ))
        ->add('content','textarea')
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        $data = $form->getData();

	    $message = \Swift_Message::newInstance()
	        ->setSubject('[YourSite] contact '.$data['name'])
	        ->setFrom($data['email'])
	        ->setTo($app['config']['general']['destinataire'])
	        ->setBody($data['content']);

	    $app['mailer']->send($message);

        // do something with the data
		$app['session']->getFlashBag()->add('message', 'Merci pour votre message '.$data["name"]);
        // redirect somewhere
        return $app->redirect('contact2',301);
    }

    // display the form
    return $app['twig']->render(VERSION.'contact.twig', array('form' => $form->createView()));
})
->bind('Contact2');


$app->before(function (Symfony\Component\HttpFoundation\Request $request) use ($app) {
    $token = $app['security']->getToken();
    $app['user'] = null;
    if ($token && !$app['security.trust_resolver']->isAnonymous($token)) {
        $app['user'] = $token->getUser();
    }
});


$app->get('/login', function () use ($app) {
    return $app['twig']->render(VERSION.'login.twig', array(
        'login_paths' => $app['oauth.login_paths'],
        'logout_path' => $app['url_generator']->generate('logout', array(
            '_csrf_token' => $app['oauth.csrf_token']('logout')
        ))
    ));
});
$app->match('/logout', function () {
})->bind('logout');
