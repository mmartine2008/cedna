<?php

/**
 * Este servicio es responsable de editar usuarios exitentes y de realizar
 * acciones referidas a ususarios tales como reset de password, envio de mail 
 * y validacion de password.
 * 
 * @author      Mariano Martinez
 */


namespace Autenticacion\Service;

use DBAL\Entity\Usuarios;
use DBAL\Entity\UsuariosxPerfiles;
use DBAL\Entity\Jurisdicciones;

use Zend\Crypt\Password\Bcrypt;
use Zend\Mail;
use Zend\Mail\Message as MessageMail;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplateMapResolver;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;


class UserManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager; 
    
    
    private $smtp_options;
    
    private $perfilesManager;

    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager, $options, $perfilesManager) 
    {
        $this->entityManager = $entityManager;
        $this->smtp_options = $options;
        $this->perfilesManager = $perfilesManager;
    }
    
    /**
     * Dado un userName devuelve la instancia de Usuarios
     * @param type $userName
     * @return type
     */
    public function getUser($userName) {
        $user = $this->entityManager->getRepository(Usuarios::class)
                ->findOneBy(["NombreUsuario" => $userName]);

        return $user;
    }
    
    /**
     * Este metodo actualiza datos de un usuario ya existente
     */
    public function updateUser($user, $data) 
    {
        // No permite cambiar el correo electrónico del usuario si ya hay otro usuario con dicho correo electrónico.
        if($user->getEmail()!=$data['email'] && $this->checkUserExists($data['email'])) {
            throw new \Exception("Ya existe otro usuario con el mail: " . $data['email']);
        }
        
        $user->setEmail($data['email']);
        $user->setFullName($data['full_name']);        
        $user->setStatus($data['status']);        
        
        // Aplicar cambios en la base de datos
        $this->entityManager->flush();

        return true;
    }
    
    /**
     * Comprueba si un usuario activo con una dirección de correo electrónico
     *  dada ya existe en la base de datos.
     */
    public function checkUserExists($email) {
        
        $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($email);
        
        return $user !== null;
    }
    
    /**
     * Comprueba que la contraseña dada sea correcta.
     */
    public function validatePassword($user, $password) 
    {
        $bcrypt = new Bcrypt();
        $passwordHash = $user->getPassword();
        
        if ($bcrypt->verify($password, $passwordHash)) {
            return true;
        }
        
        return false;
    }
    
    
    /**
     * A partir del usuario, primero busca si existe, sino emite un mensaje
     * de error. Si existe le genera una clave, la registra en la base, emite
     * un mensaje y envia un mail.
     * 
     * @param type $userName
     * @return string
     */
    public function resetPassword($userName)
    {
        $user = $this->getUser($userName);
       
        if ($user == null)
        {
           return 'No existe el usuario ingresado';
        }
        
        $mensaje = $this->enviarNuevaClave($user);
        
        return $mensaje;
    }
    
    public function getRandomPass($size) 
    {
	$valores = array();
	// Numeros
	for ($i = 48; $i <= 57; $i++)
	{
            $valores[] = chr($i);
	} 
	// Letras Mays y Min.
	for ($i = 65; $i <= 90; $i++)
	{
            $valores[] = chr($i);
            $valores[] = chr($i +32);
	} 
	$valores[] = '_';

	$pass = '';
	for ($i = 0; $i <= $size; $i++)
	{
            $pass .= $valores[rand(0, count($valores)-1)];
	}
        
        return $pass;
    }
    
    public function enviarNuevaClave($user)
    {
        $email = $user->getEmail();
        if (trim($email) == '')
        {
            return 'El usuario no tien email definido';
        }
        
        $pass = $this->getRandomPass(10);

        $user->setClave($pass);
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();
            
        try
        {
            $this->enviarMailNuevaClave($user->getFullName(), $email, $pass);
        } catch (Exception $ex) {
            $mensaje = "Ha ocurrido un error en el envio de la nueva clave";
        }
        $mensaje = "Se ha enviado la nueva clave al correo ".$email;
        
        return $mensaje;
    }
    
    public function enviarMailNuevaClave($username, $email, $pass)
    {
        $renderer = new PhpRenderer();
        
        $resolver   = new TemplateMapResolver();
        $resolver->setMap(array('mailTemplate' => __DIR__ . '/../../view/usuarios/login/email-change-password.phtml'));
        
        $renderer->setResolver($resolver);
        
        $model = new ViewModel(['username' => $username, 'pass' => $pass]);
        $model->setTemplate('mailTemplate');

        $mail = new Mail\Message();
        $mail->setEncoding('utf-8');

        $bodyText = $renderer->render($model);
        
        $bodyPart = new \Zend\Mime\Message();

        $bodyMessage = new \Zend\Mime\Part($bodyText);
        $bodyMessage->type = 'text/html';

        $bodyPart->setParts(array($bodyMessage));

        $mail->addTo($email)
            ->setSubject('Ministerio de Ambiente y Desarrollo Sustentable')
            ->setFrom('support@mayds.gob.ar','MAyDS')
            ->setBody($bodyPart);
        
        $transport = new SmtpTransport();

        $smtp_options = $this->getSMTPOptions();

        $options = new SmtpOptions($smtp_options);
        
        
        $transport->setOptions($options);
        $transport->send($mail);
        
 
    }
    
    public function getSMTPOptions()
    {
        return $this->smtp_options;
    }
    
    public function sendMailPrueba($datos)
    {
        $mailfrom = $datos['mailfrom'];
        $mailto   =  $datos['mailto'];
        $mailsubject   =  $datos['mailsubject'];
        $mailbody   =  $datos['mailbody'];

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

        $mail = new MessageMail();
        $mail->setBody($mailbody);
        $mail->setFrom($mailfrom);
        $mail->addTo($mailto);
        $mail->setSubject($mailsubject);
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
     * Esta funcion devuelve la lista completa de usuarios internos del sistema
     */
    public function getUsuariosInternos(){
        $usuarios = $this->entityManager->getRepository(Usuarios::class)->findAll();
        
        return $usuarios;
    }    

    
    public function deleteUsuario($IdUsuario){
        $usuario = $this->entityManager->getRepository(Usuarios::class)->findOneBy(["id" => $IdUsuario]);
        
        $this->entityManager->remove($usuario);
        $this->entityManager->flush();
    }    
    
    /**
     * Se utiliza en la busqueda de usuarios. Arma los parametros de busqueda
     * @param type $nombre
     * @param type $apellido
     * @param type $usuario
     * @param type $jurisdiccion
     * @param type $bloqueado
     * @return type
     */
    private function getParametros($nombre, $apellido, $usuario, $jurisdiccion, $bloqueado)
    {
        $parametros = [];
        if(trim($nombre) != ''){
            $parametros['nombre'] = $nombre;
        } 
        if(trim($apellido) != ''){
            $parametros['apellido'] = $apellido;
        }

        if(trim($usuario) != ''){
            $parametros['fullName'] = $usuario;
        }
        if($jurisdiccion != -1){
            $parametros['jurisdiccion'] = $this->entityManager->
                                        getRepository(Jurisdicciones::class)
                                        ->findOneBy(['id' => $jurisdiccion]);
        }
        $parametros['bloqueado'] = $bloqueado;
        
        return $parametros;
    }
    
    public function buscarUsuarios($nombre,$apellido,$usuario, $jurisdiccion, $bloqueado){

        $parametros = $this->getParametros($nombre, $apellido, $usuario, $jurisdiccion, $bloqueado);
                
        $usuarios = $this->entityManager->getRepository(Usuarios::class)->findBy($parametros);
        
        return $usuarios;
    }    

    public function getUsuario($IdUsuario){
        $usuario = $this->entityManager
                            ->getRepository(Usuarios::class)
                            ->findOneBy(['id' => $IdUsuario]);
        
        return $usuario;
    }
  
    public function altaUsuario($data){
        $usuario = new Usuarios();
        
        $this->perfilesManager->setPerfiles($usuario, $data);
        $this->setDatosUsuario($usuario, $data);
        
        $usuario->setBloqueado(0);
        $usuario->setFullName($data['nombreUsuario']);
        $usuario->setClave($data['clave']);
        
        $usuario->setDateCreated(new \DateTime("now"));
        
        $this->entityManager->persist($usuario);
        $this->entityManager->flush();
    }
    
    private function removePerfiles($usuario){
        $usuariosxPerfil = $this->entityManager->
            getRepository(UsuariosxPerfiles::class)->findBy(['usuario'=>$usuario]); 
        
        foreach ($usuariosxPerfil as $perfil){             
            $this->entityManager->remove($perfil);
            $this->entityManager->flush();   
        }
    }
    
    /**
     * Funcion que desactiva todos los perfiles del Usuario pasado como parametro.
     * 
     * @param Usuarios $Usuario
     */
    public function desactivarPefiles($Usuario){
        $UsuarioxPerfil = $this->entityManager->getRepository(UsuariosxPerfiles::class)->findBy(['usuario' => $Usuario]);
        
        foreach($UsuarioxPerfil as $UserxPerfil){
            $UserxPerfil->setActivo(0);
            
            $this->entityManager->persist($UserxPerfil);
            $this->entityManager->flush();
        }
    }
    
    public function modificarUsuario($data){
        $usuario = $this->entityManager
                ->getRepository(Usuarios::class)
                ->findOneBy(['id' => $data['IdUsuario']]);
        
        $this->removePerfiles($usuario);
        $this->perfilesManager->setPerfiles($usuario, $data);
        $this->setDatosUsuario($usuario, $data);
        
        $this->entityManager->persist($usuario);
        $this->entityManager->flush();
    }    
    
    private function setDatosUsuario($usuario, $data){
        $usuario->setNombre($data['nombre']);
        $usuario->setApellido($data['apellido']);
        $usuario->setEmail($data['email']);
       
        if(array_key_exists('radioSi', $data)){
            $usuario->setBloqueado(1);
         }
         else{
             $usuario->setBloqueado(0);
         }
        
        $juris =  $this->entityManager->getRepository(Jurisdicciones::class)
                        ->findOneBy(['id' => $data['jurisdiccion']]);
        $usuario->setJurisdiccion($juris);
        
    }    
    
    public function getUsuarioXPerfil($userName){
        
        $usuario = $this->entityManager->
                getRepository(Usuarios::class)->findOneBy(['fullName' => $userName]);
               
        return  $this->entityManager->
                getRepository(UsuariosxPerfiles::class)->findOneBy(['usuario' => $usuario]);
    }
    
    /**
     * Funcion que a partir de un Usuario devuelve un arreglo con los perfiles
     * activos. Se determina si un Perfil esta activo para un Usuario 
     * en la tabla Relacion de UsuariosXPerfil.
     * 
     * @param Usuarios $Usuario
     * @return array
     */
    public function getPerfilesActivos($Usuario){
        
        $UsuarioXPerfil = $this->entityManager
                    ->getRepository(UsuariosxPerfiles::class)->findBy(['Usuario' => $Usuario]);
        $output = [];
        
        foreach($UsuarioXPerfil as $UserxPerfil){
            if ($UserxPerfil->getActivo() == 1){
                $output[] = $UserxPerfil->getPerfil();
            }
        }

        return $output;
    }
}
