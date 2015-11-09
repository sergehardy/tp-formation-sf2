<?php
/**
 * Created by PhpStorm.
 * User: shardy
 * Date: 04/11/2015
 * Time: 18:10
 */

namespace Ariase\SatisfactionBundle\Manager;


use Ariase\SatisfactionBundle\Event\SatisfactionEvent;
use Symfony\Bundle\TwigBundle\TwigEngine;

class MailManager
{
    public function __construct(\Swift_Mailer $mailer,TwigEngine $templating){
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function onSatisfactionCreation(SatisfactionEvent $event)
    {
        $this->sendSatisfactionMessage($event->getSatisfaction());
    }

    public function sendSatisfactionMessage($satisfaction)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Nouvelle Satisfaction')
            ->setFrom('shardy@jouve.fr')
            ->setTo('shardy@jouve.fr')
            ->setBody(
                $this->templating->render(
                    'SatisfactionBundle:Mail:satisfaction.html.twig',
                    array('satisfaction' => $satisfaction )
                )
            )
            ;
        $this->mailer->send($message);
    }
}