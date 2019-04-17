<?php

namespace DoctrineORMModule\Proxy\__CG__\DBAL\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Pregunta extends \DBAL\Entity\Pregunta implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', 'id', 'descripcion', 'tipoPregunta', 'tieneOpciones', 'funcion', 'opciones', 'preguntaGeneradora'];
        }

        return ['__isInitialized__', 'id', 'descripcion', 'tipoPregunta', 'tieneOpciones', 'funcion', 'opciones', 'preguntaGeneradora'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Pregunta $proxy) {
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
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', [$id]);

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getPreguntaGeneradora()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPreguntaGeneradora', []);

        return parent::getPreguntaGeneradora();
    }

    /**
     * {@inheritDoc}
     */
    public function addOpciones(\DBAL\Entity\Opcion $opciones = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addOpciones', [$opciones]);

        return parent::addOpciones($opciones);
    }

    /**
     * {@inheritDoc}
     */
    public function getOpciones()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOpciones', []);

        return parent::getOpciones();
    }

    /**
     * {@inheritDoc}
     */
    public function removeOpciones($opciones)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeOpciones', [$opciones]);

        return parent::removeOpciones($opciones);
    }

    /**
     * {@inheritDoc}
     */
    public function removeAllOpciones()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeAllOpciones', []);

        return parent::removeAllOpciones();
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
    public function setDescripcion($descripcion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescripcion', [$descripcion]);

        return parent::setDescripcion($descripcion);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipoPregunta()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipoPregunta', []);

        return parent::getTipoPregunta();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipoPregunta($tipoPregunta)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipoPregunta', [$tipoPregunta]);

        return parent::setTipoPregunta($tipoPregunta);
    }

    /**
     * {@inheritDoc}
     */
    public function getTieneOpciones()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTieneOpciones', []);

        return parent::getTieneOpciones();
    }

    /**
     * {@inheritDoc}
     */
    public function tieneOpciones()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'tieneOpciones', []);

        return parent::tieneOpciones();
    }

    /**
     * {@inheritDoc}
     */
    public function setTieneOpciones($tieneOpciones)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTieneOpciones', [$tieneOpciones]);

        return parent::setTieneOpciones($tieneOpciones);
    }

    /**
     * {@inheritDoc}
     */
    public function getFuncion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFuncion', []);

        return parent::getFuncion();
    }

    /**
     * {@inheritDoc}
     */
    public function setFuncion($funcion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFuncion', [$funcion]);

        return parent::setFuncion($funcion);
    }

    /**
     * {@inheritDoc}
     */
    public function tieneFuncion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'tieneFuncion', []);

        return parent::tieneFuncion();
    }

    /**
     * {@inheritDoc}
     */
    public function getListaDestinos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getListaDestinos', []);

        return parent::getListaDestinos();
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
