<?php

/**
 * Created by Cod3r Kane.
 * Date: 10/09/2016
 * Time: 01:58
 */

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class AuthModel
{
    private $table;
    private $container;

    public function __construct(TableGateway $tableGateway, \Interop\Container\ContainerInterface $container)
    {
        $this->table = $tableGateway;
        $this->container = $container;
    }

    public function loginThisUser($user, $pass)
    {
        /** @var $userModel User **/
        $userModel = $this->container->get(User::class);

        $user = $this->validateThisUserAndReturn($user, $pass);

        if ($user) {
            $userModel->setUser($user['usuario']);
            $userModel->setId($user['id']);
        }
    }

    public function validateThisUserAndReturn($username, $pass)
    {
        $row = $this->table->select([
            'usuario' => $username,
            'senha' => $pass,
        ])->getDataSource()->current();

        return $row;
    }
}