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
     * @ORM\ManyToOne(targetEntity="Permiso")
     * @ORM\JoinColumn(name="IdPermiso", nullable=true, referencedColumnName="IdPermiso")
     */
    protected $permiso;

    /**
     * @ORM\ManyToOne(targetEntity="Pregunta")
     * @ORM\JoinColumn(name="IdPregunta", nullable=true, referencedColumnName="IdPregunta")
     */
    protected $pregunta;

    /**
     * @ORM\ManyToOne(targetEntity="Seccion")
     * @ORM\JoinColumn(name="IdSeccion", nullable=true, referencedColumnName="IdSeccion")
     */
    protected $seccion;

    /**
     * @ORM\ManyToOne(targetEntity="Relevamientos")
     * @ORM\JoinColumn(name="IdRelevamiento", nullable=true, referencedColumnName="IdRelevamiento")
     */
    protected $relevamiento;

    /**
     * @ORM\ManyToOne(targetEntity="Opcion")
     * @ORM\JoinColumn(name="IdOpcion", nullable=true, referencedColumnName="IdOpcion")
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
     * Get the value of permiso
     */ 
    public function getPermiso()
    {
        return $this->permiso;
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

    /**
     * Get the value of seccion
     */ 
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * Set the value of seccion
     *
     * @return  self
     */ 
    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;

        return $this;
    }

    /**
     * Get the value of relevamiento
     */ 
    public function getRelevamiento()
    {
        return $this->relevamiento;
    }

    /**
     * Set the value of relevamiento
     *
     * @return  self
     */ 
    public function setRelevamiento($relevamiento)
    {
        $this->relevamiento = $relevamiento;

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

    public function poseeMultiplesDestinos(){
        $this->getPregunta()->getTipoPregunta()->esPeguntaMultiple();
    }


    public function getJSON(){
        $output = "";
        $output .= '"idRespuesta": "' . $this->getId() .'", ';
        $output .= '"pregunta": "' . $this->getPregunta()->getDescripcion() .'", ';
        $output .= '"seccion": "' . $this->getSeccion()->getId() .'", ';
        $output .= '"relevamiento": "' . $this->getRelevamiento()->getId() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'"';
        if ($this->getPermiso()) {
            ', '.$output .= '"permiso": ' . $this->getPermiso()->getJSON().'"' ;
        }
        if ($this->getOpcion()) {
            ', '. $output .= '"opcion": ' . $this->getOpcion()->getJSON().'"';
            if ($this->getPregunta()->getTipoPregunta()->esPeguntaMultiple()) {
                ', '. $output .= '"destino": ' . $this->getDestino().'"';
            }
        }
        return '{' . $output . '}';
    }

}