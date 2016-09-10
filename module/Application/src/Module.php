<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Model\Api\SintegraModel;
use Application\Model\Api\SintegraModelFactory;
use Application\Model\AuthModel;
use Application\Model\AuthModelFactory;
use Application\Model\User;
use Zend\ServiceManager\Factory\InvokableFactory;

class Module
{
    const VERSION = '3.0.2dev';

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                SintegraModel::class => SintegraModelFactory::class,
                AuthModel::class => AuthModelFactory::class,
                User::class => InvokableFactory::class,
            ),
        );
    }
}
