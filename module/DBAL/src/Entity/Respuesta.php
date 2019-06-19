<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineORMModule\Proxy\__CG__\DBAL\Entity\Pregunta;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="Respuesta")
 */
class Respuesta
{
    /**
     * @ORM\Id
     * @ORM\Column(name="IdRespuesta", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="Descripcion",  nullable=true, type="string", length=2000)
     */
    protected $descripcion;

    /**
     * @ORM\Column(name="NombreArchivo",  nullable=true, type="string", length=300)
     */
    protected $nombreArchivo;

    /**
     * @ORM\ManyToOne(targetEntity="Pregunta")
     * @ORM\JoinColumn(name="IdPregunta", nullable=true, referencedColumnName="IdPregunta")
     */
    protected $pregunta;

    /**
    * @ORM\ManyToOne(targetEntity="RelevamientosxSecciones")
    * @ORM\JoinColumn(name="IdRelevamientoxSeccion", nullable=true, referencedColumnName="IdRelevamientoxSeccion")
    */
    protected $relevamientoxSeccion;

    /**
     * @ORM\Column(name="IdOpcion",  nullable=true, type="integer")
     */
    protected $opcion;

    /**
     * @ORM\Column(name="Destino",  nullable=true, type="string", length=100)
     */
    protected $destino;

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
     * Get the value of pregunta
     */ 
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set the value of pregunta
     *
     * @return  self
     */ 
    public function setPregunta($pregunta)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get the value of relevamiento
     */ 
    public function getRelevamientoxSeccion()
    {
        return $this->relevamientoxSeccion;
    }

    /**
     * Set the value of relevamiento
     *
     * @return  self
     */ 
    public function setRelevamientoxSeccion($relevamientoxSeccion)
    {
        $this->relevamientoxSeccion = $relevamientoxSeccion;

        return $this;
    }

    /**
     * Get the value of destino
     */ 
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Set the value of destino
     *
     * @return  self
     */ 
    public function setDestino($destino)
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get the value of opcion
     */ 
    public function getOpcion()
    {
        return $this->opcion;
    }

    /**
     * Set the value of opcion
     *
     * @return  self
     */ 
    public function setOpcion($opcion)
    {
        $this->opcion = $opcion;

        return $this;
    }

    public function poseeMultiplesDestinos(){
        $this->getPregunta()->getTipoPregunta()->esPeguntaMultiple();
    }

    /**
     * Get the value of nombreArchivo
     */ 
    public function getNombreArchivo()
    {
        return $this->nombreArchivo;
    }

    /**
     * Set the value of nombreArchivo
     *
     * @return  self
     */ 
    public function setNombreArchivo($nombreArchivo)
    {
        $this->nombreArchivo = $nombreArchivo;

        return $this;
    }


    public function getJSON(){
        $output = "";
        $output .= '"idRespuesta": "' . $this->getId() .'", ';
        $output .= '"pregunta": ' . $this->getPregunta()->getJson() .', ';

        $destino = "";
        if ($this->getOpcion()) {
            $output .= '"opcion": "' . $this->getOpcion().'", ';
            $output .= '"respuesta": "", ';
            if ($this->getPregunta()->getTipoPregunta()->esPeguntaMultiple()) {
                $destino = $this->getDestino();
            } 
        }
        $output .= '"destino": "' .$destino.'", ';
        $output .= '"idRelevamientoxSeccion": "' .$this->getRelevamientoxSeccion()->getId().'", ';        
        $output .= '"respuesta": "' . $this->getDescripcion() .'"';
        return '{' . $output . '}';
    }

}