<?php
namespace Formulario\Service;

class CednaTcpdf extends \TCPDF
{   
    private $titulo ;
    private $fechaEmision ;
    private $image_file;

    public function Header() {
        // Logo
        $this->Image($this->getLogo(), 20, 15, 30, '', 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
       

        $this->SetFont('helvetica', '', 15);
        $this->setCellMargins(1, 1, 1, 1);

        $this->Ln(5);
        $this->Cell(0,15, $this->getTitulo(), 0, false, 'C', 0, "", 0, false, 'M', 'M');
        $this->Ln(5);
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 15, "Fecha de Emisión: ". $this->getFechaEmision(), 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $this->Ln(10);
        $html ='<hr>';
        $this->writeHTML($html, true, false, true, false, '');
    }

    public function Footer() {
        $html ='<hr>';
        $this->writeHTML($html, true, false, true, false, '');
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Ln(5);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    } 

    /**
     * Get the value of titulo
     */ 
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     *
     * @return  self
     */ 
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get the value of fechaEmision
     */ 
    public function getFechaEmision()
    {
        return $this->fechaEmision;
    }

    /**
     * Set the value of fechaEmision
     *
     * @return  self
     */ 
    public function setFechaEmision($fechaEmision)
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    /**
     * Get the value of logo
     */ 
    public function getLogo()
    {
        return $this->image_file;
    }

    /**
     * Set the value of logo
     *
     * @return  self
     */ 
    public function setLogo($image_file)
    {
        $this->image_file = $image_file;

        return $this;
    }

}