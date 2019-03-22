<?php
namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="app.TiposEvento")
 */
class TiposEvento
{
    const ALTA_ORD_COMPRA = 'Alta de Ordenes de Compra';
    const EDICION_ORD_COMPRA = 'Editar Ordenes de Compra';
    const PERMISO_PARA_FIRMAR = 'Permiso de trabajo disponible para firmar';
    const PERMISO_FIRMADO = 'Permiso de trabajo completamente firmado';
    const PERMISO_PARA_EDITAR = 'Permiso de trabajo disponible para editar';
    const FIRMA_DELEGADA = 'Firma de Permiso de trabajo delegada';
    const ALTA_TAREAS = 'Alta de Tareas';
    const EDITAR_TAREAS = 'Editar Tarea';
    const ALTA_OPERARIOS = 'Alta de Operarios';
    const EDITAR_OPERARIOS = 'Editar Operario';

    /**
     * @ORM\Id
     * @ORM\Column(name="IdTipoEvento", type="integer")
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

    public function getJSON(){
        $output = "";

        $output .= '"id": "' . $this->getId() .'", ';
        $output .= '"descripcion": "' . $this->getDescripcion() .'"';
        
        return '{' . $output . '}';
    }
}