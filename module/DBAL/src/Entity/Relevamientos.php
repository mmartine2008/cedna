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
     * @ORM\OneToMany(targetEntity="RelevamientosxSecciones", mappedBy="relevamiento")
     */
    protected $RelevamientosxSecciones;

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
        $this->RelevamientossxSecciones = new ArrayCollection();
    }

    /**
     * @return array
     */
    public function getRelevamientosxSecciones()
    {
        if ($this->RelevamientosxSecciones){
            return $this->RelevamientosxSecciones->toArray();
        }else{
            return null;
        }
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
        $nodosFirmantes = [];
        foreach ($this->getNodosFirmantesRelevamiento() as $nodoFirmante) {
            $nodosFirmantes[] = $nodoFirmante->getJSON();
        }
        $nodosFirmantes = implode(", ", $nodosFirmantes);

        $RelevamientosxSecciones = [];
        if($this->getRelevamientosxSecciones()) {
            foreach ($this->getRelevamientosxSecciones() as $RelevamientoxSeccion) {
                $RelevamientosxSecciones[] = $RelevamientoxSeccion->getJSON();
            }
        }
        
        $RelevamientosxSecciones = implode(", ", $RelevamientosxSecciones);


        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"secciones": ['.$RelevamientosxSecciones.'],';
        $output .= '"nodosFirmantes": ['.$nodosFirmantes.'],';
        $output .= '"estadoRelevamiento": ' . $this->getEstadoRelevamiento()->getJSON() ;
        
        return '{' . $output . '}';
    }
}