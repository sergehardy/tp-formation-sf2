<?php

namespace Ariase\SatisfactionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name,
            'locale'=>$this->get('session')->get('lang'));
    }

    /**
     * @Route("/setlocale/{lang}", name="setlocale")
     * @Template()
     */
    public function setLocaleAction($lang)
    {
        $session = $this->get('session');

        $session->set('lang',$lang);
        $session->getFlashBag()
            ->add('notice', 'Lang updated');

        $url = $this->container->get('request')->headers->get('referer');

        if(!$url)
            $url="/";

        return new RedirectResponse($url);
    }

    /**
     * @Route("/notes/{annee}/{mois}", name="notes_campagne")
     * @Template()
     */
    public function notesListAction($annee,$mois)
    {
        $notes = $this->get('doctrine')->getRepository('SatisfactionBundle:Satisfaction')
        ->createQueryBuilder('s')
        ->select('s,c')
        ->join('s.campaign','c')
        ->where('c.annee= :annee')
        ->setParameter('annee',$annee)
        ->setParameter('mois',$mois)
        ->andWhere('c.mois= :mois',$mois)
        ->getQuery()->getResult()
        ;
        var_dump($notes);
        return ['notes'=>$notes];
    }
    /**
    * @Template()
    */
    public function menuGaucheCampagnesAction()
    {
        $campagnes = $this->get('doctrine')->getRepository('SatisfactionBundle:Campaign')->findAll();
        return ['campagnes'=>$campagnes,'selected'=>'2015'];
    }

    /**
     * @Template()
     */
    public function footerAction()
    {
        return array('locale'=>$this->get('session')->get('lang'),
            'locales'=>array('fr'=>"FR",'en'=>"EN"));
    }
}
