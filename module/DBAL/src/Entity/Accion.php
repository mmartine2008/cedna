<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Accion")
 */
class Accion
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="nombre")
     */
    protected $nombre;

    /**
     * @ORM\Column(name="titulo")
     */
    protected $titulo;


    /**
     * @ORM\Column(name="icono")
     */
    protected $icono;

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function setIcono($icono)
    {
        $this->icono = $icono;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getIcono()
    {
        return $this->icono;
    }

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"nombre": "' . $this->getNombre() .'", ';
        $output .= '"titulo": "' . $this->getTitulo() .'", ';
        $output .= '"icono": "' . $this->getIcono() .'"';
        
        return '{' . $output . '}';
    }
}