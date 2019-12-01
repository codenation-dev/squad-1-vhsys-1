<?php


namespace Central\Actions;


use Central\Entity\EntidadeBase;
use Doctrine\ORM\EntityManager;

class ActionBase
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function persistir(EntidadeBase $entidade)
    {
        $this->entityManager->persist($entidade);
        $this->entityManager->flush();
    }

    protected function remover(EntidadeBase $entidade)
    {
        $this->entityManager->remove($entidade);
        $this->entityManager->flush();
    }
}