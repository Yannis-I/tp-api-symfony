<?php
namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use App\Entity\Animal;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class AnimalFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $countries = $manager->getRepository(Country::class)->findAll();

        if (!$countries) {
            throw new \Exception('Il n\'y a pas de pays en base de données. Veuillez exécuter CountryFixtures avant d\'exécuter AnimalFixtures.');
        }

        for ($i = 0; $i < 100; $i++) {
            $animal = new Animal();
            $animal->setNom($faker->name());
            $animal->setTaille($faker->numberBetween(10, 200));
            $animal->setArtMartial($faker->randomElement(['Catwondo', 'Kong Fu', 'Karateckel', 'Judog', 'Catoeira', 'Crabe Maga', 'Mouette Thai', 'Kung Foque', 'Aikidoberman', 'Samboa', 'Caninjutsu', 'Jujitsouris', 'karatekachalot', 'Capoeiraptor']));
            $animal->setTel($faker->phoneNumber());
            $animal->setCountry($faker->randomElement($countries));
            $animal->setDureeDeVie($faker->numberBetween(2, 30));

            $manager->persist($animal);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CountryFixtures::class,
        );
    }

    public static function getGroups(): array
    {
        return ['animal'];
    }
}
