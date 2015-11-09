<?php
/**
 * Created by PhpStorm.
 * User: shardy
 * Date: 01/11/2015
 * Time: 21:49
 */

namespace Ariase\SatisfactionBundle\Manager;

use Ariase\SatisfactionBundle\Entity\Satisfaction;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\EventDispatcher\EventDispatcher;

class SatisfactionManager
{
    private $doctrine;

    public function __construct(Registry $doctrine,EventDispatcher $dispatcher)
    {
        $this->doctrine = $doctrine;
        $this->dispatcher = $dispatcher;
    }
    public function persistAndFlush(Satisfaction $satisfaction){

        $em = $this->em->getManager();
        $em->persist($satisfaction);
        $em->flush();
        $this->dispatcher->dispatch("satisfaction.creation",new SatisfactionEvent($satisfaction));

    }
    public function findNotesByAnneeAndMois($annee,$mois)
    {
        return $this->doctrine->getRepository('SatisfactionBundle:Satisfaction')
        ->createQueryBuilder('s')
        ->select('s,c')
        ->join('s.campaign','c')
        ->where('c.annee=:annee')
        ->andWhere('c.mois=:mois')
        ->setParameter('annee',$annee)
        ->setParameter('mois',$mois)
        ->getQuery()->getResult()
        ;
    }

    public function findCampagnesForMenu()
    {
        return $this->doctrine->getRepository('SatisfactionBundle:Campaign')->findAll();
    }

    public function findAll()
    {
        return $this->doctrine->getRepository('SatisfactionBundle:Satisfaction')->findAll();
    }

}