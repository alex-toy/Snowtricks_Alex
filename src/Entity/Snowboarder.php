<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SnowboarderRepository")
 */
class Snowboarder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
	 * @Assert\NotBlank()
     * @ORM\Column(type="string", length=100)
     */
    private $name;


    
    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $password;
    
    
    /**
	 * @Assert\NotBlank()
     * @ORM\Column(type="string", length=100)
     */
    private $email;
    
    
    /**
     * @ORM\Column(type="integer", length=100)
     */
    private $token;

    
    
    function __construct() {
        this->token = 1;
    }
    
    
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    
    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }
    
    
    
    

}
