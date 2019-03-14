<?php

namespace Application\Service;

use Zend\Crypt\Password\Bcrypt;
use Zend\Mail;
use Zend\Mail\Message as MessageMail;
//use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplateMapResolver;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

class MailManager {
    
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    
    private $smtp_options;
    
    
    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager, $smtp_options) 
    {
        $this->entityManager = $entityManager;
        $this->smtp_options = $smtp_options;
    }

    /**
     * Si extendidas esta en false, recupera las extritamente necesarias
     */
    public function getSMTPOptions($extendidas = true)
    {
        $output = [];
        
        foreach ($this->smtp_options as $index => $valor)
        {
            $output[$index] = $valor;
        }
        
        if (!$extendidas)
        {
            unset($output['default_subject']);
            unset($output['default_from_mail']);
            unset($output['default_from_alias']);
        }

        return $output;
    }

    /**
     * Funcion que hace efectivo el envio de Mail.
     * Recibe como primer parametro un areglo formado de la siguiente manera:
     * ['Body' => '', 
     *  'From' => '', 
     *  'To' => '', 
     *  'Subject' => '']
     * 
     * Y en el segundo parametro los datos de configuracion de SMTP.
     *
     * @param [array] $parametrosMail
     * @param [array] $smtp_options
     * @return string
     */
    private function enviarMail($parametrosMail, $smtp_options){
        $mail = new MessageMail();
        
        $mail->setBody($parametrosMail['Body']);
        $mail->setFrom($parametrosMail['From']);
        $mail->addTo($parametrosMail['To']);
        $mail->setSubject($parametrosMail['Subject']);
        $mail->setEncoding('utf-8');

        $transport = new SmtpTransport();
        $options = new SmtpOptions($smtp_options);
        $transport->setOptions($options);

        try {
            $transport->send($mail);
            $mensaje = "Enviado";
        } catch (Exception $ex) {
            $mensaje = ($ex->getTraceAsString());

        }

        return $mensaje;
    }

    /**
     * Funcion que procesa el envio de mail de prueba.
     *
     * @param [array] $datos
     * @return string
     */
    public function sendMailPrueba($datos)
    {
        $parametros = [
            'From' => $datos['mailfrom'],
            'To' => $datos['mailto'],
            'Subject' => $datos['mailsubject'],
            'Body' => $datos['mailbody']
        ];
        
        $smtp_options = [
            'name' => $datos['name'],
            'host' => $datos['host'],
            'connection_class' => 'login',
            'port' => $datos['port'],
            'connection_config' => [
                'ssl' => $datos['ssl'],
                'username' => $datos['username'],
                'password' => $datos['password'],
            ]
        ];

        $mensaje = $this->enviarMail($parametros, $smtp_options);

        return $mensaje;
    }
    
}