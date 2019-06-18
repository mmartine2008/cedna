<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DBAL\Entity\Pregunta;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="app.Seccion")
 */
class Seccion
{
    const ID_SECCION_FIRMAS = [17, 18, 19];

    /**
     * @ORM\Id
     * @ORM\Column(name="IdSeccion", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="Nombre",  nullable=true, type="string", length=100)
     */
    protected $nombre;

    /**
     * @ORM\Column(name="Descripcion",  nullable=true, type="string", length=1000)
     */
    protected $descripcion;

    /**
     * @ORM\Column(name="esObligatoria",  nullable=true, type="integer")
     */
    protected $esObligatoria;

   /**
     * @ORM\OneToMany(targetEntity="SeccionPregunta", mappedBy="seccion")
     */
    protected $seccionPreguntas;

    public function __construct() {
        // $this->preguntas = new ArrayCollection();
        $this->seccionPreguntas = new ArrayCollection();

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
     * @return array
     */
    public function getSeccionPreguntas()
    {
        if ($this->seccionPreguntas){
            return $this->seccionPreguntas->toArray();
        }else{
            return null;
        }
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

    public function esSeccionFirmas(){
        return (\in_array($this->id, SELF::ID_SECCION_FIRMAS));
    }

     /**
     * Get the value of esObligatoria
     */ 
    public function getEsObligatoria()
    {
        return $this->esObligatoria;
    }

    /**
     * Set the value of esObligatoria
     *
     * @return  self
     */ 
    public function setEsObligatoria($esObligatoria)
    {
        $this->esObligatoria = $esObligatoria;

        return $this;
    }

    public function getJSON(){
        $output = "";

        $seccionPreguntas = [];
        foreach ($this->getSeccionPreguntas() as $seccionPregunta) {
            $seccionPreguntas[] = $seccionPregunta->getJSON();
        }
        $seccionPreguntas = implode(", ", $seccionPreguntas);

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"nombre": "' . $this->getNombre() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'", ';
        $output .= '"preguntas": ['.$seccionPreguntas.'], ';
        $output .= '"esSeccionFirmas": "' . $this->esSeccionFirmas() .'"';
        $output .= '"esObligatoria": "' . $this->getEsObligatoria() .'"';

        return '{' . $output . '}';
    }


   
}