<?php


namespace Central\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="erro")
 */
class Erro extends EntidadeBase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="erroCollection", cascade={"persist", "merge", "refresh"})
     */
    public $token;
    /**
     * @ORM\Column(type="string")
     */
    public $titulo;
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
    public $origem;
    /**
     * @ORM\Column(type="string")
     */
    public $detalhe;
    /**
     * @ORM\Column(type="string")
     */
    public $ambiente;
    /**
     * @ORM\Column(type="boolean")
     */
    public $arquivado;
}
