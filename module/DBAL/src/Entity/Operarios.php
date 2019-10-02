<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Operarios")
 */
class Operarios
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdOperario", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="Nombre")
     */
    protected $Nombre;


    /**
     * @ORM\Column(name="Apellido")
     */
    protected $Apellido;


    /**
     * @ORM\Column(name="CUIT")
     */
    protected $CUIT;


    /**
     * @ORM\Column(name="Telefono")
     */
    protected $Telefono;


    /**
     * @ORM\Column(name="Email")
     */
    protected $Email;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="IdContratista", referencedColumnName="IdUsuario")
     */
    protected $Contratista;

    /**
     * @ORM\ManyToMany(targetEntity="Inducciones", inversedBy="Operario", cascade={"persist"})
     * @ORM\JoinTable(name="dbo.InduccionXOperario",
     *      joinColumns={@ORM\JoinColumn(name="IdOperario", referencedColumnName="IdOperario")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="IdInduccion", referencedColumnName="IdInduccion")}
     *      )
     */
    protected $Inducciones;

    public function __construct() {
        $this->Inducciones = new ArrayCollection();
    }

    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;
    }

    public function setApellido($Apellido)
    {
        $this->Apellido = $Apellido;
    }

    public function setCuit($CUIT)
    {
        $this->CUIT = $CUIT;
    }

    public function setTelefono($Telefono)
    {
        $this->Telefono = $Telefono;
    }

    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    public function setContratista($Contratista)
    {
        $this->Contratista = $Contratista;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->Nombre;
    }

    public function getApellido()
    {
        return $this->Apellido;
    }

    public function getCuit()
    {
        return $this->CUIT;
    }

    public function getTelefono()
    {
        return $this->Telefono;
    }

    public function getEmail()
    {
        return $this->Email;
    }

    public function getContratista()
    {
        return $this->Contratista;
    }

    /**
     * @return array
     */
    public function getInducciones()
    {
        if ($this->Inducciones){
            return $this->Inducciones->toArray();
        }else{
            return null;
        }
    }

    public function getJSON(){
        $inducciones = [];
        foreach ($this->getInducciones() as $induccion) {
            $inducciones[] = $induccion->getJSON();
        }
        $inducciones = implode(", ", $inducciones);

        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"nombre": "' . $this->getNombre() .'", ';
        $output .= '"apellido": "' . $this->getApellido() .'", ';
        $output .= '"cuit": "' . $this->getCuit() .'", ';
        $output .= '"telefono": "' . $this->getTelefono() .'", ';
        $output .= '"contratista": ' . $this->getContratista()->getJSON() .', ';
        $output .= '"email": "' . $this->getEmail() .'",';
        $output .= '"inducciones": ['.$inducciones.']';
        
        return '{' . $output . '}';
    }
}