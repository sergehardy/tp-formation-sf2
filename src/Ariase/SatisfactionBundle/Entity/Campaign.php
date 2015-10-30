<?php

namespace Ariase\SatisfactionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Campaign
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Campaign
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="mois", type="integer")
     */
    private $mois;

    /**
     * @var integer
     *
     * @ORM\Column(name="annee", type="integer")
     */
    private $annee;


    /**
     * @ORM\OneToMany(targetEntity="Satisfaction", mappedBy="campaign")
     */
    protected $satisfactions;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mois
     *
     * @param integer $mois
     *
     * @return Campaign
     */
    public function setMois($mois)
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * Get mois
     *
     * @return integer
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set annee
     *
     * @param integer $annee
     *
     * @return Campaign
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return integer
     */
    public function getAnnee()
    {
        return $this->annee;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->satisfactions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add satisfaction
     *
     * @param \Ariase\SatisfactionBundle\Entity\Satisfaction $satisfaction
     *
     * @return Campaign
     */
    public function addSatisfaction(\Ariase\SatisfactionBundle\Entity\Satisfaction $satisfaction)
    {
        $this->satisfactions[] = $satisfaction;

        return $this;
    }

    /**
     * Remove satisfaction
     *
     * @param \Ariase\SatisfactionBundle\Entity\Satisfaction $satisfaction
     */
    public function removeSatisfaction(\Ariase\SatisfactionBundle\Entity\Satisfaction $satisfaction)
    {
        $this->satisfactions->removeElement($satisfaction);
    }

    /**
     * Get satisfactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSatisfactions()
    {
        return $this->satisfactions;
    }
}
