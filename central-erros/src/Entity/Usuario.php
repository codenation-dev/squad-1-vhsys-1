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

    private static $container;

    public function __construct(
        string $token,
        string $senha,
        string $email
    )
    {
        $this->token = $token;
        $this->senha = $senha;
        $this->email = $email;
    }

    public static function factory(
        string $token,
        string $senha,
        string $email
    )
    {
        return new self(
            $token,
            $senha,
            $email);
    }

    public function __toString()
    {
        return json_encode($this);
    }
}