<?php
/**
 * Created by Cod3r Kane.
 * Date: 10/09/2016
 * Time: 03:08
 */

namespace Application\Controller;


use Application\Model\Api\SintegraModel;
use Application\Model\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PanelController extends AbstractActionController
{
    private $container;

    public function __construct(\Interop\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function indexAction()
    {
        /** @var User $userModel */
        $userModel = $this->container->get(User::class);

        if ($userModel->user()) {
            return new ViewModel();
        } else {
            $this->redirect()->toRoute('home');
        }
    }

    public function listAction()
    {
        /** @var User $userModel */
        $userModel = $this->container->get(User::class);

        if ($userModel->user()) {
            /** @var SintegraModel $model */
            $model = $this->container->get(SintegraModel::class);
            $items = $model->getLoggedUserList();
            $result = [];
            foreach ($items as $item) {
                $result[] = "
                    <tr>
                        <td>{$item['id']}</td>
                        <td><pre style='max-width: 800px;'>{$item['resultado_json']}</pre></td>
                        <td><button data-id='{$item['id']}' onclick='deleteIntegra(this.attributes[0].value)' class='btn btn-danger'>Deletar</button></td>
                    </tr>
                ";
            }
            $this->layout()->setVariable('list', $result);
            return new ViewModel();
        } else {
            $this->redirect()->toRoute('home');
        }
    }
}