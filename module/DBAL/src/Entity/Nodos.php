<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

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

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"tipoNodo": ' . $this->getTipoNodo()->getJSON() .', ';
        $output .= '"nombre": "' . $this->getNombre() .'", ';
        if ($this->getNodoSuperior()){
            $output .= '"nodoSuperior": ' . $this->getNodoSuperior()->getJSON() .', ';
        }else{
            $output .= '"nodoSuperior": "", ';
        }
        
        return '{' . $output . '}';
    }
}