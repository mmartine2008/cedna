<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Nodos")
 */
class Nodos
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdNodo", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="TipoNodo")
     * @ORM\JoinColumn(name="IdTipoNodo", referencedColumnName="IdTipoNodo")
     */
    protected $TipoNodo;

    /**
     * @ORM\Column(name="Nombre")
     */
    protected $Nombre;

    /**
     * @ORM\ManyToOne(targetEntity="Nodos")
     * @ORM\JoinColumn(name="IdNodoSuperior", referencedColumnName="IdNodo")
     */
    protected $NodoSuperior;

    /**
     * @ORM\ManyToMany(targetEntity="Usuarios", inversedBy="Nodo", cascade={"persist"})
     * @ORM\JoinTable(name="esJefeDe",
     *      joinColumns={@ORM\JoinColumn(name="IdNodo", referencedColumnName="IdNodo")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="IdUsuario", referencedColumnName="IdUsuario")}
     *      )
     */
    protected $Jefes;

    public function __construct() {
        $this->Jefes = new ArrayCollection();
    }

    public function setTipoNodo($TipoNodo)
    {
        $this->TipoNodo = $TipoNodo;
    }

    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;
    }

    public function setNodoSuperior($NodoSuperior)
    {
        $this->NodoSuperior = $NodoSuperior;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTipoNodo()
    {
        return $this->TipoNodo;
    }

    public function getNombre()
    {
        return $this->Nombre;
    }

    public function getNodoSuperior()
    {
        return $this->NodoSuperior;
    }

    public function getJefes()
    {
        if ($this->Jefes){
            return $this->Jefes->toArray();
        }else{
            return null;
        }
    }

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"tipoNodo": ' . $this->getTipoNodo()->getJSON() .', ';
        $output .= '"nombre": "' . $this->getNombre() .'", ';
        if ($this->getNodoSuperior()){
            $output .= '"nodoSuperior": ' . $this->getNodoSuperior()->getJSON() .'';
        }else{
            $output .= '"nodoSuperior": ""';
        }
        
        return '{' . $output . '}';
    }
}