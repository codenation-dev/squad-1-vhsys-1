<?php


namespace Central\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;
    /**
     * @ORM\Column(type="string")
     */
    public $token;
    /**
     * @ORM\Column(type="string")
     */
    public $senha;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    public $email;
}