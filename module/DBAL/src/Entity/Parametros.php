<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="dbo.Parametros")
 */
class Parametros
{
    /**
     * @ORM\Id
     * @ORM\Column(name="Id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="Parametro",  nullable=true, type="string", length=80)
     */
    protected $parametro;

    /**
     * @ORM\Column(name="Valor",  nullable=true, type="string", length=20)
     */
    protected $valor;

    /**
     * @ORM\Column(name="Descripcion",  nullable=true, type="string", length=255)
     */
    protected $descripcion;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of parametro
     */ 
    public function getParametro()
    {
        return $this->parametro;
    }

    /**
     * Set the value of parametro
     *
     * @return  self
     */ 
    public function setParametro($parametro)
    {
        $this->parametro = $parametro;

        return $this;
    }

    /**
     * Get the value of valor
     */ 
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set the value of valor
     *
     * @return  self
     */ 
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getJSON(){
        $output = "";
        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"nombre": "' . $this->getParametro() .'", ';
        $output .= '"valor": "' . $this->getValor() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'"';
        
        return '{' . $output . '}';
    }
}