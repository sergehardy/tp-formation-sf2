<?php
namespace Ariase\SatisfactionBundle\DataFixtures;
use Ariase\SatisfactionBundle\Entity\Campaign;
use Ariase\SatisfactionBundle\Entity\Satisfaction;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSatisfactionData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$c1 = (new Campaign())->setMois(10)->setAnnee(2015);
        $c2 = (new Campaign())->setMois(11)->setAnnee(2015);

		$s1 = (new Satisfaction())->setNote(5)->setCommentaire('ça va')->setCampaign($c1);
		$s2 = (new Satisfaction())->setNote(3)->setCommentaire('bof')->setCampaign($c2);
		$manager->persist($s1);
		$manager->persist($s2);
		$manager->persist($c1);
		$manager->persist($c2);
		$manager->flush();
	}
} 