<?php
/**
 * Created by Cod3r Kane.
 * Date: 10/09/2016
 * Time: 02:27
 */

namespace Application\Model;

class User
{
    private $user;
    private $id;

    public function __construct()
    {
        $this->user = $_SESSION['user'] && $_SESSION['user']['username'] || false;
        $this->id = $_SESSION['user'] && $_SESSION['user']['id'] || false;
    }

    public function user()
    {
        return $this->user || $_SESSION['user']['username'] || false;
    }

    public function setUser($user)
    {
        $this->user = $user;
        $_SESSION['user']['username'] = $user;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        $_SESSION['user']['id'] = $id;
    }
}