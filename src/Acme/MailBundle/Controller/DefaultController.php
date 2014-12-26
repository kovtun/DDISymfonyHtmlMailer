<?php

namespace Acme\MailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Acme\MailBundle\MailGenerator\MailGenerator as MailGenerator;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('AcmeMailBundle:Default:index.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function supportAction(Request $request) {
        $twig = $this->get('twig'); // a Twig_Environment instance
        $generator = new MailGenerator($twig);
        $form = $this->createFormBuilder()
            ->add('name', 'text', array('required'=>true))
            ->add('email', 'email', array('required'=>true))
            ->add('type', 'choice', array(
                'choices' => array(
                    'Type1' => 'Theme one',
                    'Type2' => 'Theme two',
                    'Type3' => 'Theme three',
                    'Type4' => 'Theme four',
                    'Type5' => 'Theme five',
                )))
            ->add('message', 'textarea', array('required'=>true))
            ->add('send', 'submit', array('label' => 'SEND'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $message_info = $form->getData();
            $message = $generator->getMessage('example', array(
                'username' => $message_info['name'],
                'type' => $message_info['type'],
                'info' => ($message_info['message'] . ' Email: ' . $message_info['email'])
            ));
            $message->setTo($message_info['email'])
                ->setFrom($message_info['email'])
            ;
            $sent =$this->get('mailer')->send($message);
            $count = 1;
            if( $sent == $count){
                $result = "<div class='alert alert-success'>
                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
                    <strong>Success!</strong>
                    Your message has been sent successfully.</div>";
            }else{
                $result ="<div class='alert alert-error'>
                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
                    <strong>Error!</strong>
                    Your message has not been sent.</div>";
            }

            return $this->render('AcmeMailBundle:Default:index.html.twig', array(
                'missive' => TRUE,
                'result' => $result
            ));
        }
        return $this->render('AcmeMailBundle:Default:mail.html.twig', array(
            'form' => $form->createView(),
            'missive' => FALSE
        ));
    }

}
