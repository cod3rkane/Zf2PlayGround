<?php
/**
 * Created by Cod3r Kane.
 * Date: 09/09/2016
 * Time: 17:04
 */

namespace Application\Controller\Api;


use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Model\Api\SintegraModel;

class SintegraControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $model = $container->get(SintegraModel::class);

        return new SintegraController($model, $container);
    }

}