<?php


namespace Central\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario extends EntidadeBase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;
    /**
     * @ORM\Column(type="string", unique=true)
     * @ORM\OneToMany(targetEntity="Erro", mappedBy="usuario", cascade={"all"}, orphanRemoval=true, fetch="LAZY")
     */
    public $token;
    /**
     * @ORM\Column(type="string")
     */
    public $token_recuperacao_senha;
    /**
     * @ORM\Column(type="string")
     */
    public $senha;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    public $email;

    /**
     * @return string
     */
    public function getSenha(): string
    {
        return $this->senha;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

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
        $this->token_recuperacao_senha = "";
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
}