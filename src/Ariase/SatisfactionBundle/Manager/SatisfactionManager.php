<?php
/**
 * Created by PhpStorm.
 * User: shardy
 * Date: 01/11/2015
 * Time: 21:49
 */

namespace Ariase\SatisfactionBundle\Manager;


class SatisfactionManager
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
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

}