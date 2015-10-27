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

        $url = $this->container->get('request')->headers->get('referer');

        if(!$url)
            $url="/";

        return new RedirectResponse($url);
    }
}
