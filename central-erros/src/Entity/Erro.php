<?php


namespace Central\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="erro")
 */
class Erro
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
    public $codigo;
    /**
     * @ORM\Column(type="string")
     */
    public $token;
    /**
     * @ORM\Column(type="string")
     */
    public $nivel;
    /**
     * @ORM\Column(type="string")
     */
    public $ip;
    /**
     * @ORM\Column(type="string")
     */
    public $data_hora;
    /**
     * @ORM\Column(type="string")
     */
    public $titulo;
    /**
     * @ORM\Column(type="string")
     */
    public $detalhe;
    /**
     * @ORM\Column(type="string")
     */
    public $status;
    /**
     * @ORM\Column(type="string")
     */
    public $ambiente;
    /**
     * @ORM\Column(type="string")
     */
    public $origem;
}

