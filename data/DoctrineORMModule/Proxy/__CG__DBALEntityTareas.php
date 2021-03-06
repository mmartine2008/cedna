<?php

namespace DoctrineORMModule\Proxy\__CG__\DBAL\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Tareas extends \DBAL\Entity\Tareas implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'id', 'Solicitante', 'Ejecutor', 'Responsable', 'PlanificaTarea', 'Nodo', 'EstadoTarea', 'OrdenDeCompra', 'TipoPlanificacion', 'FechaSolicitud', 'Descripcion', 'Resumen', 'Planificaciones'];
        }

        return ['__isInitialized__', 'id', 'Solicitante', 'Ejecutor', 'Responsable', 'PlanificaTarea', 'Nodo', 'EstadoTarea', 'OrdenDeCompra', 'TipoPlanificacion', 'FechaSolicitud', 'Descripcion', 'Resumen', 'Planificaciones'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Tareas $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function setSolicitante($Solicitante)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSolicitante', [$Solicitante]);

        return parent::setSolicitante($Solicitante);
    }

    /**
     * {@inheritDoc}
     */
    public function setNodo($Nodo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNodo', [$Nodo]);

        return parent::setNodo($Nodo);
    }

    /**
     * {@inheritDoc}
     */
    public function setEjecutor($Ejecutor)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEjecutor', [$Ejecutor]);

        return parent::setEjecutor($Ejecutor);
    }

    /**
     * {@inheritDoc}
     */
    public function setResponsable($Responsable)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setResponsable', [$Responsable]);

        return parent::setResponsable($Responsable);
    }

    /**
     * {@inheritDoc}
     */
    public function setTipoPlanificacion($TipoPlanificacion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipoPlanificacion', [$TipoPlanificacion]);

        return parent::setTipoPlanificacion($TipoPlanificacion);
    }

    /**
     * {@inheritDoc}
     */
    public function setPlanificaTarea($PlanificaTarea)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPlanificaTarea', [$PlanificaTarea]);

        return parent::setPlanificaTarea($PlanificaTarea);
    }

    /**
     * {@inheritDoc}
     */
    public function setEstadoTarea($EstadoTarea)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEstadoTarea', [$EstadoTarea]);

        return parent::setEstadoTarea($EstadoTarea);
    }

    /**
     * {@inheritDoc}
     */
    public function setOrdenDeCompra($OrdenDeCompra)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOrdenDeCompra', [$OrdenDeCompra]);

        return parent::setOrdenDeCompra($OrdenDeCompra);
    }

    /**
     * {@inheritDoc}
     */
    public function setFechaSolicitud($FechaSolicitud)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechaSolicitud', [$FechaSolicitud]);

        return parent::setFechaSolicitud($FechaSolicitud);
    }

    /**
     * {@inheritDoc}
     */
    public function setDescripcion($Descripcion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescripcion', [$Descripcion]);

        return parent::setDescripcion($Descripcion);
    }

    /**
     * {@inheritDoc}
     */
    public function setResumen($Resumen)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setResumen', [$Resumen]);

        return parent::setResumen($Resumen);
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getSolicitante()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSolicitante', []);

        return parent::getSolicitante();
    }

    /**
     * {@inheritDoc}
     */
    public function getEjecutor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEjecutor', []);

        return parent::getEjecutor();
    }

    /**
     * {@inheritDoc}
     */
    public function getResponsable()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getResponsable', []);

        return parent::getResponsable();
    }

    /**
     * {@inheritDoc}
     */
    public function getPlanificaTarea()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlanificaTarea', []);

        return parent::getPlanificaTarea();
    }

    /**
     * {@inheritDoc}
     */
    public function getTipoPlanificacion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipoPlanificacion', []);

        return parent::getTipoPlanificacion();
    }

    /**
     * {@inheritDoc}
     */
    public function getNodo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNodo', []);

        return parent::getNodo();
    }

    /**
     * {@inheritDoc}
     */
    public function getEstadoTarea()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstadoTarea', []);

        return parent::getEstadoTarea();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrdenDeCompra()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOrdenDeCompra', []);

        return parent::getOrdenDeCompra();
    }

    /**
     * {@inheritDoc}
     */
    public function getFechaSolicitud()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechaSolicitud', []);

        return parent::getFechaSolicitud();
    }

    /**
     * {@inheritDoc}
     */
    public function getDescripcion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescripcion', []);

        return parent::getDescripcion();
    }

    /**
     * {@inheritDoc}
     */
    public function getResumen()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getResumen', []);

        return parent::getResumen();
    }

    /**
     * {@inheritDoc}
     */
    public function getPlanificaciones()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlanificaciones', []);

        return parent::getPlanificaciones();
    }

    /**
     * {@inheritDoc}
     */
    public function getJSON()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getJSON', []);

        return parent::getJSON();
    }

}
