<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     *
     * @ORM\ManyToMany(targetEntity="Seccion", inversedBy="Relevamiento", cascade={"persist"})
     * @ORM\JoinTable(name="RelevamientosxSecciones",
     *      joinColumns={@ORM\JoinColumn(name="IdRelevamiento", referencedColumnName="IdRelevamiento")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="IdSeccion", referencedColumnName="IdSeccion")}
     *      )
     */
    protected $secciones;

    /**
     * @ORM\ManyToOne(targetEntity="EstadosRelevamiento")
     * @ORM\JoinColumn(name="IdEstadoRelevamiento", referencedColumnName="IdEstadoRelevamiento")
     */
    protected $EstadoRelevamiento;

    /**
     * @ORM\OneToMany(targetEntity="NodosFirmantesRelevamiento", mappedBy="Relevamiento")
     */
    protected $NodosFirmantesRelevamiento;

    public function __construct() {
        $this->NodosFirmantesRelevamiento = new ArrayCollection();
        $this->secciones = new ArrayCollection();
    }

    /**
     * @param Seccion|null $secciones
     */
    public function addSecciones($secciones = null)
    {
        if (!$this->secciones->contains($secciones)) {
            $this->secciones->add($secciones);
        }
    }

    /**
     * @return array
     */
    public function getSecciones()
    {
        if ($this->secciones){
            return $this->secciones->toArray();
        }else{
            return null;
        }
    }
    
    /**
     * @param Seccion $secciones
     */
    public function removeSecciones($secciones)
    {
        if (!$this->secciones->contains($secciones)) {
            return;
        }
        $this->secciones->removeElement($secciones);
    }

    /**
     * @desc Remove all tags for this article
     */
    public function removeAllSecciones()
    {
        $this->secciones->clear();
    }

    public function setEstadoRelevamiento($EstadoRelevamiento)
    {
        $this->EstadoRelevamiento = $EstadoRelevamiento;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEstadoRelevamiento()
    {
        return $this->EstadoRelevamiento;
    }

    public function getNodosFirmantesRelevamiento()
    {
        if ($this->NodosFirmantesRelevamiento){
            return $this->NodosFirmantesRelevamiento->toArray();
        }else{
            return null;
        }
    }

    public function getJSON(){
        $secciones = [];
        foreach ($this->getSecciones() as $seccion) {
            $secciones[] = $seccion->getJSON();
        }
        $secciones = implode(", ", $secciones);

        $nodosFirmantes = [];
        foreach ($this->getNodosFirmantesRelevamiento() as $nodoFirmante) {
            $nodosFirmantes[] = $nodoFirmante->getJSON();
        }
        $nodosFirmantes = implode(", ", $nodosFirmantes);

        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"secciones": ['.$secciones.'],';
        $output .= '"nodosFirmantes": ['.$nodosFirmantes.'],';
        $output .= '"estadoRelevamiento": ' . $this->getEstadoRelevamiento()->getJSON() ;
        
        return '{' . $output . '}';
    }
}