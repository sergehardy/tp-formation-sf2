<?php
namespace Ariase\SatisfactionBundle\DataFixtures;
use Ariase\SatisfactionBundle\Entity\Campaign;
use Ariase\SatisfactionBundle\Entity\Satisfaction;
use Ariase\SatisfactionBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSatisfactionData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$c1 = (new Campaign())->setMois(10)->setAnnee(2015);
        $c2 = (new Campaign())->setMois(11)->setAnnee(2015);
		$c3 = (new Campaign())->setMois(10)->setAnnee(2014);


		$s1 = (new Satisfaction())->setNote(4)->setCommentaire('ça va')->setCampaign($c1);
		$s2 = (new Satisfaction())->setNote(3)->setCommentaire('bof')->setCampaign($c1);
		$s3 = (new Satisfaction())->setNote(5)->setCommentaire('génial')->setCampaign($c2);
		$s4 = (new Satisfaction())->setNote(1)->setCommentaire('pas content')->setCampaign($c3);

		$toPersist = [$c1,$c2,$c3,$s1,$s2,$s3,$s4];

		foreach($toPersist as $e)
			$manager->persist($e);

		$user = new User();
		$user->setUsername('serge')->setPlainPassword('serge')->setEmail('shardy@jouve.fr')
			->addRole("ROLE_ADMIN");

		$manager->persist($user);
		$manager->flush();
	}
} 