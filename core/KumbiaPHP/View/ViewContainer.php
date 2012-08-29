<?php

namespace KumbiaPHP\View;

use \ArrayAccess;
use KumbiaPHP\Di\Container\Container;
use KumbiaPHP\Di\Definition\Service;

/**
 * Clase contenedora de los helpers para las vistas
 *
 * @author maguirre
 */
class ViewContainer implements ArrayAccess
{

    public $content;

    /**
     * 
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $container->getDefinitionManager()
                ->addService(new Service('html','KumbiaPHP\\View\\Helper\\Html'))
                ->addService(new Service('form','KumbiaPHP\\View\\Helper\\Form'))
                ->addService(new Service('tag','KumbiaPHP\\View\\Helper\\Tag'));
        $this->container = $container;
    }

    public function offsetExists($offset)
    {
        return $this->container->has($offset);
    }

    public function offsetGet($offset)
    {
        try {
            return $this->container->get($offset);
        } catch (\Exception $e) {
            throw new \Exception(sprintf('No existe el helper <b>%s</b>', $offset));
        }
    }

    public function offsetSet($offset, $value)
    {
        //nada por ahora
    }

    public function offsetUnset($offset)
    {
        //nada por ahora
    }

    public function __toString()
    {
        return $this->content;
    }

}