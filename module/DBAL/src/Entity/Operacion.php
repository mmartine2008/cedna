<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Operacion")
 */
class Operacion
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

    /**
     * @ORM\ManyToOne(targetEntity="Operacion")
     * @ORM\JoinColumn(name="grupoId", referencedColumnName="Id")
     */
    protected $grupo;

    /**
     * @ORM\Column(name="orden")
     */
    protected $orden;

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

    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    public function setOrden($orden)
    {
        $this->orden = $orden;
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

    public function getGrupo()
    {
        return $this->grupo;
    }

    public function getOrden()
    {
        return $this->orden;
    }
}