<?php
use Silex\Provider\FormServiceProvider;
/*
création d'un objet Silex application
c'est la base du framework
*/
$app = new Silex\Application();
/* 
on affiche toutes les erreurs pour le mode debug
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);
$app['debug'] = true;
/*
constante version inhérent au tutoriel
determine quelles pages html on affiche
*/
define('VERSION', 'V2/');

/*
initialisation de la bibliotheque twig
elle facilite l'affichage entre les données
issus du php et les structures des pages html
http://silex.sensiolabs.org/doc/providers/twig.html
*/
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/views',
));
/*
OPTIONEL
on crée un fonction pour récupérer les ressources plus facilement
et evideter les chemins à ralonge dans les pages html
*/
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) {
        // TODO: replace silextuto par une variable

        return sprintf('/silexTuto/web/src/%s', ltrim($asset, '/'));
    }));

    return $twig;
}));

/*
initialisation de la bibliotheque  urlgenerator 
pour pouvoir faire des chemins depuis les pages html
http://silex.sensiolabs.org/doc/providers/url_generator.html
*/
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
/*
initialisation de la bibliotheque  form
pour faciliter la création de  formulaires
http://silex.sensiolabs.org/doc/providers/form.html
*/
$app->register(new FormServiceProvider());
/*
initialisation de la bibliotheque Translation
pour faciliter la traduction
prerequis à d'autres bibilotheques
http://silex.sensiolabs.org/doc/providers/translation.html
*/
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));
/*
initialisation de la bibliotheque session
pour faciliter la sauvegarde de session d'utilisateur
http://silex.sensiolabs.org/doc/providers/session.html
*/
$app->register(new Silex\Provider\SessionServiceProvider(), array(
    'session.storage.save_path' => __DIR__ . '/../cache'
));
/*
initialisation de la bibliotheque  YamlConfig
pour faciliter la lecture des fichiers de parametre
*/
$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/setting.yml'));
/*
initialisation de la bibliotheque  Doctrine
pour faciliter l'interaction avec la bdd
http://silex.sensiolabs.org/doc/providers/doctrine.html
*/
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $app['config']['database']
));
/*
initialisation de la bibliotheque  Swiftmailer
pour faciliter l'envoi de mail
http://silex.sensiolabs.org/doc/providers/swiftmailer.html
*/
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app['swiftmailer.options'] = $app['config']['swiftmailer'];



return $app;