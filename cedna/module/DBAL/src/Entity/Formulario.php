<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Formulario")
 */
class Formulario
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdFormulario", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

     /**
     * @ORM\ManyToOne(targetEntity="Permiso")
     * @ORM\JoinColumn(name="IdPermiso", nullable=true, referencedColumnName="IdPermiso")
     */
    protected $permiso;

    /**
     * @ORM\Column(name="Descripcion",  nullable=true, type="string", length=1000)
     */
    protected $descripcion;

    /**
     * @ORM\Column(name="Nombre",  nullable=true, type="string", length=100)
     */
    protected $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Seccion", mappedBy="formulario")
     */
    protected $secciones;

    /**
     * @ORM\ManyToMany(targetEntity="Perfiles", inversedBy="Formulario", cascade={"persist"})
     * @ORM\JoinTable(name="dbo.FirmanFormulario",
     *      joinColumns={@ORM\JoinColumn(name="IdFormulario", referencedColumnName="IdFormulario")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="IdPerfil", referencedColumnName="IdPerfil")}
     *      )
     */
    protected $PerfilesFirmantes;
    
    public function __construct()
    {
        $this->secciones = new ArrayCollection();
        $this->PerfilesFirmantes = new ArrayCollection();
    }

    public function getSecciones()
    {
        if ($this->secciones){
            return $this->secciones->toArray();
        }else{
            return null;
        }
    }

    public function getPerfilesFirmantes()
    {
        if ($this->PerfilesFirmantes){
            return $this->PerfilesFirmantes->toArray();
        }else{
            return null;
        }
    }

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
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        if ($this->descripcion){
            return $this->descripcion;
        } else {
            return "";
        }
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

    /**
     * Get the value of permiso
     */ 
    public function getPermiso()
    {
        return $this->permiso;
    }

      /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of permiso
     *
     * @return  self
     */ 
    public function setPermiso($permiso)
    {
        $this->permiso = $permiso;

        return $this;
    }

    public function addPerfilFirmante(Perfiles $perfil = null)
    {
        if (!$this->PerfilesFirmantes->contains($perfil)) {
            $this->PerfilesFirmantes->add($perfil);
        }
    }

    public function getJSON(){
        $output = "";

        $secciones = [];
        foreach ($this->getSecciones() as $seccion) {
            $secciones[] = $seccion->getJSON();
        }
        $secciones = implode(", ", $secciones);

        $perfilesFirmantes = [];
        foreach ($this->getPerfilesFirmantes() as $perfil) {
            $perfilesFirmantes[] = $perfil->getJSON();
        }
        $perfilesFirmantes = implode(", ", $perfilesFirmantes);

        $output .= '"idFormulario": "' . $this->getId() .'", ';
        $output .= '"nombre": "' . $this->getNombre() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'", ';
        $output .= '"secciones": ['.$secciones.'], ';
        $output .= '"perfilesFirmantes": ['.$perfilesFirmantes.']';
        
        return '{' . $output . '}';
    }

}