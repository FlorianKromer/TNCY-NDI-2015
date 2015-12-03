<?php

define('FACEBOOK_API_KEY',    $app['config']['oauth']['facebook_api_key']);
define('FACEBOOK_API_SECRET', $app['config']['oauth']['facebook_api_secret']);
define('TWITTER_API_KEY',     $app['config']['oauth']['twitter_api_key']);
define('TWITTER_API_SECRET',  $app['config']['oauth']['twitter_api_secret']);
define('GOOGLE_API_KEY',      $app['config']['oauth']['google_api_key']);
define('GOOGLE_API_SECRET',   $app['config']['oauth']['google_api_secret']);
define('GITHUB_API_KEY',      $app['config']['oauth']['github_api_key']);
define('GITHUB_API_SECRET',   $app['config']['oauth']['github_api_secret']);

$app->register(new Gigablah\Silex\OAuth\OAuthServiceProvider(), array(
'oauth.services' => array(
        'Facebook' => array(
            'key' => FACEBOOK_API_KEY,
            'secret' => FACEBOOK_API_SECRET,
            'scope' => array('email'),
            'user_endpoint' => 'https://graph.facebook.com/me'
        ),
        'Twitter' => array(
            'key' => TWITTER_API_KEY,
            'secret' => TWITTER_API_SECRET,
            'scope' => array(),
            // Note: permission needs to be obtained from Twitter to use the include_email parameter
            'user_endpoint' => 'https://api.twitter.com/1.1/account/verify_credentials.json?include_email=true',
            'user_callback' => function ($token, $userInfo, $service) {
                $token->setUser($userInfo['name']);
                $token->setEmail($userInfo['email']);
                $token->setUid($userInfo['id']);
            }
        ),
        'Google' => array(
            'key' => GOOGLE_API_KEY,
            'secret' => GOOGLE_API_SECRET,
            'scope' => array(
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile'
            ),
            'user_endpoint' => 'https://www.googleapis.com/oauth2/v1/userinfo'
        ),
        'GitHub' => array(
            'key' => GITHUB_API_KEY,
            'secret' => GITHUB_API_SECRET,
            'scope' => array('user:email'),
            'user_endpoint' => 'https://api.github.com/user'
        )
    )
));


$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'default' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'oauth' => array(
                //'login_path' => '/auth/{service}',
                //'callback_path' => '/auth/{service}/callback',
                //'check_path' => '/auth/{service}/check',
                'failure_path' => '/',
                'with_csrf' => true
            ),
            'logout' => array(
                'logout_path' => '/logout',
                'with_csrf' => true
            ),
            'users' => new Gigablah\Silex\OAuth\Security\User\Provider\OAuthInMemoryUserProvider()
        )
    ),
    'security.access_rules' => array(
        array('^/auth', 'ROLE_USER')
    )
));


