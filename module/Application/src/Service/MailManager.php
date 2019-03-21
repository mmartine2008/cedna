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
    private $translator;
    
    
    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager, $smtp_options, $catalogoManager, $translator) 
    {
        $this->entityManager = $entityManager;
        $this->smtp_options = $smtp_options;
        $this->catalogoManager = $catalogoManager;
        $this->translator = $translator;
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
    private function recuperarUsuariosPorPerfiles($arrNotificacionesXPerfil){
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

        $arrUsuariosANotificar = $this->recuperarUsuariosPorPerfiles($arrNotificacionesXPerfil);

        $this->procesarEnvioMailAUsuarios($arrUsuariosANotificar, $mensaje, $titulo);
    }

    /**
     * Funcion que se encarga de enviar un mail a un conjunto de usuarios.
     *
     * @param [array] $arrUsuariosANotificar
     * @param [string] $mensaje
     * @param [string] $titulo
     * @return void
     */
    private function procesarEnvioMailAUsuarios($arrUsuariosANotificar, $mensaje, $titulo){
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
        $TipoEvento = $this->catalogoManager->getTiposEventoPorDescripcion(TiposEvento::ALTA_ORD_COMPRA);

        $mensaje = $this->translator->translate('__mail_nueva_orden_de_compra__') . ': ' . $OrdenDeCompra->getId();

        $this->procesarEnviarNotificaciones($TipoEvento, $mensaje, $this->translate('__Nueva_Orden_de_Compra__'));
    }

    /**
     * Funcion para notificar que se ha editado los datos de 
     * una orden de compra en el sistema.
     *
     * @param [OrdenesDeCompra] $OrdenDeCompra
     * @return void
     */
    public function notificarEdicionOrdenDeCompra($OrdenDeCompra){
        $TipoEvento = $this->catalogoManager->getTiposEventoPorDescripcion(TiposEvento::EDICION_ORD_COMPRA);

        $mensaje = $this->translator->translate('__Edición_de_Orden_de_Compra__') . ': ' . $OrdenDeCompra->getId();

        $this->procesarEnviarNotificaciones($TipoEvento, $mensaje, $this->translate('__Edición_de_Orden_de_Compra__'));
    }

    /**
     * Funcion para notificar por mail a los usuarios firmantes, que el permiso de trabajo se encuentra
     * disponible para firmar.
     *
     * @param [Planificaciones] $Planificacion
     * @return void
     */
    public function notificarPermisoDisponibleParaFirmar($Planificacion){
        $TipoEvento = $this->catalogoManager->getTiposEventoPorDescripcion(TiposEvento::PERMISO_PARA_FIRMAR);

        $mensaje = "Ya se encuentra disponible para firmar el Permiso de Trabajo, correspondiente a la Tarea con ID: ".$Planificacion->getTarea()->getId();

        $parametrosTexto = ['titulo' => 'Permiso de trabajo disponible para firmar',
                            'mensaje' => $mensaje];
        
        $this->procesarEnviarNotificacionesNodoFirmantes($TipoEvento, $Planificacion, $parametrosTexto);
    }

    /**
     * Funcion que recupera todos los usuarios que tienen que firmar un permiso de trabajo,
     * a partir de un relevamiento.
     *
     * @param [Relevamientos] $Relevamiento
     * @return array
     */
    private function procesarGetUsuariosFirmantes($Relevamiento){
        $NodosFirmantes = $Relevamiento->getNodosFirmantesRelevamiento();

        $output = [];
        foreach($NodosFirmantes as $NodoFirmante){
            $output[] = $NodoFirmante->getUsuarioFirmante();
        }

        return $output;
    }

    /**
     * Funcion que procesa el envio de mails a los usuarios que pertenecen al nodo firmante
     *
     * @param [type] $TipoEvento
     * @param [type] $Planificacion
     * @param [type] $parametrosTexto
     * @return void
     */
    private function procesarEnviarNotificacionesNodoFirmantes($TipoEvento, $Planificacion, $parametrosTexto){
        $Relevamiento = $Planificacion->getRelevamiento();

        $arrUsuariosANotificar = $this->procesarGetUsuariosFirmantes($Relevamiento);

        $this->procesarEnvioMailAUsuarios($arrUsuariosANotificar, $parametrosTexto['mensaje'], $parametrosTexto['titulo']);
    }

    /**
     * Funcion que notifica por mail a los usuarios que poseen los perfiles 
     * correspondiente segun la configuracion del sistema, que un permiso de trabajo
     * fue completamente firmado.
     *
     * @param [Planificaciones] $Planificacion
     * @return void
     */
    public function notificarPermisoFirmadoCompletamente($Planificacion){
        $TipoEvento = $this->catalogoManager->getTiposEventoPorDescripcion(TiposEvento::PERMISO_FIRMADO);

        $mensaje = "Se ha firmado por completo el Permiso de Trabajo, correspondiente a la Tarea con ID: ".$Planificacion->getTarea()->getId();
        $titulo = 'Permiso de trabajo completamente firmado';
        
        $this->procesarEnviarNotificaciones($TipoEvento, $mensaje, $titulo);
    }

    /**
     * Funcion que notifica a los usuarios correspondientes que un permiso de trabajo
     * ya se encuentra disponible para comenzar su edicion.
     *
     * @param [Planificaciones] $Planificacion
     * @return void
     */
    public function notificarPermisoDisponibleParaEditar($Planificacion){
        $TipoEvento = $this->catalogoManager->getTiposEventoPorDescripcion(TiposEvento::PERMISO_PARA_EDITAR);

        $mensaje = "Ya se encuentra disponible para editar el Permiso de Trabajo, correspondiente a la Tarea con ID: ".$Planificacion->getTarea()->getId();
        $titulo = 'Permiso de trabajo disponible para editar';

        $this->procesarEnviarNotificaciones($TipoEvento, $mensaje, $titulo);
    }

    /**
     * Funcion que notifica a los usuarios correspondiente que un usuario del sistema
     * ha delegado su firma en un permiso de trabajo.
     *
     * @param [Planificaciones] $Planificacion
     * @param [Usuarios] $UsuarioActivo
     * @param [Usuarios] $NuevoFirmante
     * @return void
     */
    public function notificarFirmaDePermisoDelegada($Planificacion, $UsuarioActivo, $NuevoFirmante){
        $TipoEvento = $this->catalogoManager->getTiposEventoPorDescripcion(TiposEvento::FIRMA_DELEGADA);

        $mensaje = "El usuario: ".$UsuarioActivo->getNombre().", ".$UsuarioActivo->getApellido()." ha delegado su firma en el Permiso de Trabajo"
            .", correspondiente a la Tarea con ID: ".$Planificacion->getTarea()->getId()." al usuario: ".$NuevoFirmante->getNombre().", ".$NuevoFirmante->getApellido();
        $titulo = 'Firma de Permiso de trabajo delegada';

        $this->procesarEnviarNotificaciones($TipoEvento, $mensaje, $titulo);
    }

    /**
     * Funcion que notifica a los usuarios correspondiente que se ha generado una nueva tarea en el sistema.
     *
     * @param [Tareas] $Tarea
     * @return void
     */
    public function notificarNuevaTarea($Tarea){
        $TipoEvento = $this->catalogoManager->getTiposEventoPorDescripcion(TiposEvento::ALTA_TAREAS);

        $mensaje = "Se ha generado una nueva Tarea en el sistema, con el ID: ".$Tarea->getId();
        $titulo = 'Nueva Tarea creada';

        $this->procesarEnviarNotificaciones($TipoEvento, $mensaje, $titulo);
    }

    /**
     * Funcion que notifica a los usuarios correspondiente que se ha editado 
     * los datos de una tarea en el sistema.
     *
     * @param [Tareas] $Tarea
     * @return void
     */
    public function notificarEdicionDeTarea($Tarea){
        $TipoEvento = $this->catalogoManager->getTiposEventoPorDescripcion(TiposEvento::EDITAR_TAREAS);

        $mensaje = "La tarea con ID: ".$Tarea->getId()." ha sido modificada";
        $titulo = 'Tarea Editada';

        $this->procesarEnviarNotificaciones($TipoEvento, $mensaje, $titulo);
    }

    /**
     * Funcion que notifica a los usuarios correspondiente que se ha creado 
     * un nuevo operario en el sistema.
     *
     * @param [Operarios] $Operario
     * @return void
     */
    public function notificarAltaDeOperario($Operario){
        $TipoEvento = $this->catalogoManager->getTiposEventoPorDescripcion(TiposEvento::ALTA_OPERARIOS);

        $mensaje = "Se ha registrado el alta de un nuevo Operario en el sistema. Operario: ".$Operario->getNombre().", ".$Operario->getApellido();
        $titulo = 'Nuevo Operario';

        $this->procesarEnviarNotificaciones($TipoEvento, $mensaje, $titulo);
    }

    /**
     * Funcion que notifica a los usuarios correspondiente que se han editado 
     * los datos de un operario del sistema.
     *
     * @param [Operarios] $Operario
     * @return void
     */
    public function notificarEdicionDeOperario($Operario){
        $TipoEvento = $this->catalogoManager->getTiposEventoPorDescripcion(TiposEvento::EDITAR_OPERARIOS);

        $mensaje = "Se han editado los datos del Operario: ".$Operario->getNombre().", ".$Operario->getApellido();
        $titulo = 'Edición de Operario';

        $this->procesarEnviarNotificaciones($TipoEvento, $mensaje, $titulo);
    }
}