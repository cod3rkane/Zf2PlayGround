<?php
/**
 * Created by Cod3r Kane.
 * Date: 09/09/2016
 * Time: 23:56
 */

namespace Application\Model\Api;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Model\Api\SintegraModel;

class SintegraModelFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get('Zend\Db\Adapter\Adapter');
        return new SintegraModel(new TableGateway('sintegra', $adapter), new TableGateway('usuario_has_sintegra', $adapter), $container);
    }

}