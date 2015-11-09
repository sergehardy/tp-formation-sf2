<?php
/**
 * Created by PhpStorm.
 * User: shardy
 * Date: 04/11/2015
 * Time: 18:07
 */

namespace Ariase\SatisfactionBundle\Event;


class SatisfactionEvent
{
    public function setSatisfaction($satisfaction)
    {
        $this->satisfaction = $satisfaction;
    }
    public function getSatisfaction()
    {
        return $this->satisfaction;
    }
}