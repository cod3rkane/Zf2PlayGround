<?php
/**
 * Created by PhpStorm.
 * User: cod3r
 * Date: 10/09/2016
 * Time: 01:56
 */

namespace Application\Controller;


use Application\Model\AuthModel;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $model = $container->get(AuthModel::class);
        return new AuthController($model, $container);
    }

}