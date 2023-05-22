<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use App\Entity\Country;
use Faker\Factory;

class CountryFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $country = new Country();
            $country->setNom($faker->country());
            $country->setCodeISO($faker->countryCode());

            $manager->persist($country);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['country'];
    }
}
