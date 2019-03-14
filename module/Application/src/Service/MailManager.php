<?php

namespace Application\Service;

use Zend\Crypt\Password\Bcrypt;
use Zend\Mail;
use Zend\Mail\Message as MessageMail;
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

    private $catalogoManager;
    
    
    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager, $smtp_options, $catalogoManager) 
    {
        $this->entityManager = $entityManager;
        $this->smtp_options = $smtp_options;
        $this->catalogoManager = $catalogoManager;
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

    /**
     * Funcion que a partir de un arreglo de NotificacionesXPerfil recupera todos los
     * usuarios que pertenecen a esos perfiles, sin repetir.
     *
     * @param [array] $arrNotificacionesXPerfil
     * @return array
     */
    private function recuperarUsuariosPorPefiles($arrNotificacionesXPerfil){
        $output = [];

        foreach($arrNotificacionesXPerfil as $NotificacionXPerfil){
            $Perfil = $NotificacionXPerfil->getPerfil();
            
            //Recupero todos los usuarios que tienen este perfil
            $arrUsuariosXPerfiles = $this->catalogoManager->getUsuariosXPerfilesPorPerfil($Perfil);
            
            foreach($arrUsuariosXPerfiles as $UsuarioXPerfil){
                $Usuario = $UsuarioXPerfil->getUsuario();
                
                if (!in_array($Usuario, $output)){
                    $output[] = $Usuario;
                }
            }
        }

        return $output;
    }

    /**
     * Funcion que procesa el envio de las notificaciones.
     *
     * @param [TiposEvento] $TipoEvento
     * @param [String] $mensaje
     * @param [String] $titulo
     * @return void
     */
    private function procesarEnviarNotificaciones($TipoEvento, $mensaje, $titulo){
        $arrNotificacionesXPerfil = $this->catalogoManager->getNotificacionesXPerfilPorTipoEvento($TipoEvento);

        $arrUsuariosANotificar = $this->recuperarUsuariosPorPefiles($arrNotificacionesXPerfil);

        foreach($arrUsuariosANotificar as $Usuario){
            $parametrosMail = [
                'Body' => $mensaje, 
                'From' => 'support@cedna.com.ar', 
                'To' => $Usuario->getEmail(), 
                'Subject' => $titulo
            ];

            $smtp_options = $this->getSMTPOptions(false);

            $this->enviarMail($parametrosMail, $smtp_options);
        }
    }

    /**
     * Funcion para notificar que se ha generado una nueva orden de compra en el sistema.
     *
     * @param [OrdenesDeCompra] $OrdenDeCompra
     * @return void
     */
    public function notificarNuevaOrdenDeCompra($OrdenDeCompra){
        $TipoEvento = $this->catalogoManager->getTiposEventoPorDescripcion('Alta de Ordenes de Compra');

        $mensaje = 'Se ha generado una nueva Órden de Compra, con el número: ' . $OrdenDeCompra->getId();

        $this->procesarEnviarNotificaciones($TipoEvento, $mensaje, 'Nueva Órden de Compra');
    }

    /**
     * Funcion para notificar que se ha editado los datos de 
     * una orden de compra en el sistema.
     *
     * @param [OrdenesDeCompra] $OrdenDeCompra
     * @return void
     */
    public function notificarEdicionOrdenDeCompra($OrdenDeCompra){
        $TipoEvento = $this->catalogoManager->getTiposEventoPorDescripcion('Editar Ordenes de Compra');

        $mensaje = 'Se han editado los datos de la Órden de Compra, con el número: ' . $OrdenDeCompra->getId();

        $this->procesarEnviarNotificaciones($TipoEvento, $mensaje, 'Edicón de Órden de Compra');
    }
    
}