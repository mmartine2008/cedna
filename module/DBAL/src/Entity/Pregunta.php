<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DBAL\Entity\Opcion;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Pregunta")
 */
class Pregunta
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdPregunta", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="Descripcion",  nullable=false, type="string", length=1000)
     */
    protected $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="TipoPregunta")
     * @ORM\JoinColumn(name="IdTipoPregunta", nullable=false, referencedColumnName="IdTipoPregunta")
     */
    protected $tipoPregunta;

    /**
     * @ORM\Column(name="Opciones",  nullable=false, type="integer", length=1)
     */
    protected $tieneOpciones;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Opcion", inversedBy="Pregunta", cascade={"persist"})
     * @ORM\JoinTable(name="PreguntaOpcion",
     *      joinColumns={@ORM\JoinColumn(name="IdPregunta", referencedColumnName="IdPregunta")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="IdOpcion", referencedColumnName="IdOpcion")}
     *      )
     */
    protected $opciones;

    public function __construct() {
        $this->opciones = new ArrayCollection();
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
     * @param Opcion|null $opciones
     */
    public function addOpciones(Opcion $opciones = null)
    {
        if (!$this->opciones->contains($opciones)) {
            $this->opciones->add($opciones);
        }
    }

    /**
     * @return array
     */
    public function getOpciones()
    {
        if ($this->opciones){
            return $this->opciones->toArray();
        }else{
            return null;
        }
    }
    
    /**
     * @param Opcion $opciones
     */
    public function removeOpciones($opciones)
    {
        if (!$this->opciones->contains($opciones)) {
            return;
        }
        $this->opciones->removeElement($opciones);
    }

    /**
     * @desc Remove all tags for this article
     */
    public function removeAllOpciones()
    {
        $this->opciones->clear();
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

    /**
     * Get the value of tipoPregunta
     */ 
    public function getTipoPregunta()
    {
        return $this->tipoPregunta;
    }

    /**
     * Set the value of tipoPregunta
     *
     * @return  self
     */ 
    public function setTipoPregunta($tipoPregunta)
    {
        $this->tipoPregunta = $tipoPregunta;

        return $this;
    }

    /**
     * Get the value of tieneOpciones
     */ 
    public function getTieneOpciones()
    {
        return $this->tieneOpciones ;
    }

     /**
     * Get the value of tieneOpciones
     */ 
    public function tieneOpciones()
    {
        if($this->tieneOpciones == 0){
            return true;
        }
        else return false;
    }

    /**
     * Set the value of tieneOpciones
     *
     * @return  self
     */ 
    public function setTieneOpciones($tieneOpciones)
    {
        $this->tieneOpciones = $tieneOpciones;

        return $this;
    }

    public function getJSON(){
        $output = "";

        $opciones = [];
        if($this->tieneOpciones()){
            foreach ($this->getOpciones() as $opcion) {
                $opciones[] = $opcion->getJSON();
            }
            $opciones = implode(", ", $opciones);
        }

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'", ';
        $output .= '"tipoPregunta": "' . $this->getTipoPregunta() .'", ';

        if($opciones){
            $output .= '"opciones": ['.$opciones.']';
        }
        
        return '{' . $output . '}';
    }

}