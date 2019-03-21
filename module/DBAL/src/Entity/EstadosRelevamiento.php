<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="app.EstadosRelevamiento")
 */
class EstadosRelevamiento
{
    const ID_PARA_EDITAR = 1;
    const ID_EDITADO = 2;
    const ID_COMPLETO = 3;
    const ID_FINALIZADO = 4;
    
    /**
     * @ORM\Id
     * @ORM\Column(name="IdEstadoRelevamiento", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="Descripcion")
     */
    protected $Descripcion;

    public function setDescripcion($Descripcion)
    {
        $this->Descripcion = $Descripcion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescripcion()
    {
        return $this->Descripcion;
    }

    public function esParaEditar(){
        return ($this->id == SELF::ID_PARA_EDITAR);
    }

    public function esEditado(){
        return ($this->id == SELF::ID_EDITADO);
    }

    public function esCompleto(){
        return ($this->id == SELF::ID_COMPLETO);
    }
    public function esFinalizado(){
        return ($this->id == SELF::ID_FINALIZADO);
    }

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'", ';
        $output .= '"esParaEditar": "' . $this->esParaEditar() .'", ';
        $output .= '"esEditado": "' . $this->esEditado() .'", ';
        $output .= '"esCompleto": "' . $this->esCompleto() .'", ';
        $output .= '"esFinalizado": "' . $this->esFinalizado() .'"';
        
        return '{' . $output . '}';
    }
}