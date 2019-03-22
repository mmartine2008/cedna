<?php
namespace Formulario\Service\Factory;

use Formulario\Service\CednaTcpdf;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CednaTcpdfFactory implements FactoryInterface{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {         
        return new CednaTcpdf();
    }
}