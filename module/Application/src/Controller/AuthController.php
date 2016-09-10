<?php
/**
 * Created by Cod3r Kane.
 * Date: 10/09/2016
 * Time: 01:49
 */

namespace Application\Controller;

use Application\Model\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\AuthModel;

class AuthController extends AbstractActionController
{
    private $model;
    private $container;

    public function __construct(AuthModel $model, \Interop\Container\ContainerInterface $container)
    {
        $this->model = $model;
        $this->container = $container;
    }

    public function loginAction()
    {
        $user = $this->params()->fromPost('username');
        $pass = $this->params()->fromPost('password');

        $this->model->loginThisUser($user, $pass);
        /** @var User $userModel */
        $userModel = $this->container->get(User::class);
        if ($userModel->user()) {
            $this->redirect()->toRoute('panel');
        } else {
            $this->redirect()->toRoute('home');
        }
    }

    public function logoutAction()
    {
        /** @var User $userModel */
        $userModel = $this->container->get(User::class);
        $userModel->setUser(false);
        $this->redirect()->toRoute('home');
    }
}