<?php

namespace EntrepriseBundle\Repository;

/**
 * EntrepriseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EntrepriseRepository extends \Doctrine\ORM\EntityRepository
{
    public function search($input,$output)
    {
        if($output == 'name')
        {
            return $this->getEntityManager()
                ->createQuery(
                    'SELECT p
                FROM EntrepriseBundle:Entreprise p
                WHERE p.name LIKE :str'
                )
                ->setParameter('str', '%'.$input.'%')
                ->getResult();
        }
        elseif($output == 'email')
        {
            return $this->getEntityManager()
                ->createQuery(
                    'SELECT p
                FROM EntrepriseBundle:Entreprise p
                WHERE p.email LIKE :str'
                )
                ->setParameter('str', '%'.$input.'%')
                ->getResult();
        }
        else
        {
            return $this->getEntityManager()
                ->createQuery(
                    'SELECT p
                FROM EntrepriseBundle:Entreprise p
                WHERE p.id LIKE :str'
                )
                ->setParameter('str', '%'.$input.'%')
                ->getResult();
        }

    }
}
