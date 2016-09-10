<?php

/**
 * Created by Cod3r Kane.
 * Date: 10/09/2016
 * Time: 01:59
 */

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthModelFactory implements FactoryInterface
{
    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get('Zend\Db\Adapter\Adapter');
        return new AuthModel(new TableGateway('usuario', $adapter), $container);
    }

}