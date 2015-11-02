<?php

namespace Ariase\SatisfactionBundle\Controller;

use Ariase\SatisfactionBundle\Entity\Satisfaction;
use Ariase\SatisfactionBundle\Entity\Campaign;
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
        return ['notes'=>$this->get('satisfaction_manager')->findNotesByAnneeAndMois($annee,$mois)];
    }

    /**
     * @Route("/notes", name="notes_all")
     * @Template()
     */
    public function notesListAllAction()
    {
        return ['notes'=>$this->get('satisfaction_manager')->findAll()];
    }


    /**
    * @Template()
    */
    public function menuGaucheCampagnesAction()
    {
        return ['campagnes'=>$this->get('satisfaction_manager')->findCampagnesForMenu(),'selected'=>'2015'];
    }

    /**
     * @Template()
     */
    public function footerAction()
    {
        return array('locale'=>$this->get('session')->get('lang'),
            'locales'=>array('fr'=>"FR",'en'=>"EN"));
    }


    /**
     * @Route("/notes/edit/{id}", name="note_edit")
     * @Template()
     */
    public function editNoteAction($id)
    {}

    /**
     * @Route("/notes/new", name="notes_new")
     * @Template()
     */
    public function newNoteAction()
    {
        $request = $this->get('request');
        $note = new Satisfaction();
        $form = $this->createFormBuilder($note)

            ->add('note','integer')
            ->add('commentaire','text')
            ->add('campaign','entity', array(
                    'class' => 'SatisfactionBundle:Campaign',
                     ))
            ->add('save','submit',array('label'=>'Créer note'))
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('notes_new');
        }

        return ['form'=>$form->createView()];
    }
    /**
     * @Route("/campagnes/new", name="campagnes_new")
     * @Template()
     */
    public function newCampaignAction()
    {
        $request = $this->get('request');
        $campaign = new Campaign();
        $form = $this->createFormBuilder($campaign)

            ->add('mois','integer')
            ->add('annee','integer')
            ->add('save','submit',array('label'=>'Créer campagne'))
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('campagnes_new');
        }

        return ['form'=>$form->createView()];
   }
}
