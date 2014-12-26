Mailer
======

Skeleton of html mailer (example for Symfony 2.6/Swift mailer).

This code is just an example of easy html mailing in Symfony 2 using Swift mailer.

Class MailGenerator generate mails using twig templates.

__Namespace:__  Acme\MailBundle\MailGenerator

__Located at__  MailBundle/MailGenerator/MailGenerator.php
        
##Methods summary


###_public_ `__construct( Twig_Environment $twig )`

Constructor

Parameters
    
        Twig_Environment $twig;

###_public_ `getMessage( string $name, array $parameters = array() )` 

Parameters

    string $name;
    
`$name` must correspond to twig file
          
     array $parameters;
     
$parameters to substitute to the rendering file

Returns

    Swift_Message()
    
##Properties summary

###_protected_ Twig_Environment `$twig_env`

    <table class="summary table table-bordered table-striped" id="properties">
