<?php

namespace Acme\MailBundle\MailGenerator;

/**
 * Generate mails using twig templates
 */
class MailGenerator {

    protected $twig_env;

    /**
     * Constructor
     * @param \Twig_Environment $twig
     */
    public function __construct($twig) {
        $this->twig_env = $twig;
    }

    /**
     *
     * @param string $name must correspond to twig file
     * @param array $parameters to substitute in the rendering file
     * @return \Swift_Message()
     */
    public function getMessage($name, $parameters = array()) {
        $template = $this->twig_env->loadTemplate(':mail:' . $name . '.mail.twig');
        $subject = $template->renderBlock('subject', $parameters);
        $bodyHtml = $template->renderBlock('body_html', $parameters);
        $bodyText = $template->renderBlock('body_text', $parameters);
        if (trim($bodyText) == "") {
            return \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setBody($bodyText, 'text/plain')
                ;
        }
        return \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setBody($bodyText, 'text/plain')
            ->addPart($bodyHtml, 'text/html')
            ;
    }

}
