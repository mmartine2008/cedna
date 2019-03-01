<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Relevamientos")
 */
class Relevamientos
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdRelevamiento", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Formulario")
     * @ORM\JoinColumn(name="IdFormulario", referencedColumnName="IdFormulario")
     */
    protected $Formulario;

    public function setFormulario($Formulario)
    {
        $this->Formulario = $Formulario;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFormulario()
    {
        return $this->Formulario;
    }

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"formulario": ' . $this->getFormulario()->getJSON();
        
        return '{' . $output . '}';
    }
}