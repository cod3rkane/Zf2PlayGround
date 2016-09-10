<?php
/**
 * Created by Cod3r Kane.
 * Date: 09/09/2016
 * Time: 15:34
 */

namespace Application\Model\Api;

use Application\Model\User;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class SintegraModel
{
    private $tableSintegra;
    private $tableUserHasSintegra;
    private $container;

    public function __construct(TableGateway $tableSintegra, TableGateway $tableUserHasSintegra, \Interop\Container\ContainerInterface $container)
    {
        $this->tableSintegra = $tableSintegra;
        $this->tableUserHasSintegra = $tableUserHasSintegra;
        $this->container = $container;
    }

    public function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k]))
                    $maskared .= $val[$k++];
            } else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

    public function saveIntegra($cnpj, $json)
    {
        $this->tableSintegra->insert([
            'cnpj' => $cnpj,
            'resultado_json' => $json,
        ]);

        $lastId = (int)$this->tableSintegra->getLastInsertValue();
        /** @var User $userModel */
        $userModel = $this->container->get(User::class);
        $this->tableUserHasSintegra->insert([
           'usuario_id' => $userModel->getId(),
            'sintegra_id' => $lastId,
        ]);
    }

    public function getLoggedUserList()
    {
        /** @var User $userModel */
        $userModel = $this->container->get(User::class);
        $rows = $this->tableUserHasSintegra->select([
            'usuario_id' => $userModel->getId(),
        ])->toArray();

        $ids = [];
        foreach ($rows as $item) {
            $ids[] = $item['sintegra_id'];
        }

        $row = $this->tableSintegra->select([
            'id' => $ids,
        ])->toArray();

        return $row;
    }

    public function delete($id)
    {
        $rowHas = $this->tableUserHasSintegra->delete(
            [
                'sintegra_id' => $id,
            ]
        );

        $rowSintegra = $this->tableSintegra->delete([
            'id' => $id,
        ]);

        return ($rowHas && $rowSintegra);
    }
}