<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\CollectionNft;
use App\Entity\Country;
use App\Entity\NFT;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    const NBCATEGORIES = 5;
    const NBCOLLECTIONS = 5;
    const NBCOUNTRIES = 5;
    const NBNFT = 10;
    public function __construct(private UserPasswordHasherInterface $hash)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i <= self::NBCATEGORIES; $i++) {
            $category = new Category();
            $category->setName($faker->word());
            $manager->persist($category);
            $categories[] = $category;
        }
        for ($i = 0; $i < self::NBCOLLECTIONS; $i++) {
            $collectionNft = new CollectionNft();
            $collectionNft->setName($faker->word());
            $manager->persist($collectionNft);
            $collectionsNft[] = $collectionNft;
        }
        for ($i = 0; $i < self::NBCOUNTRIES; $i++) {
            $country = new Country();
            $country->setName($faker->word());
            $manager->persist($country);
            $countries[] = $country;
        }

        $userAdmin = new User();
        $userAdmin->setEmail('tattyjosydu69@gmail.com')
            ->setPassword($this->hash->hashPassword($userAdmin, 'LaJosCasseLaBaraque'))
            ->setFirstname('Josy')
            ->setLastname('Zirculaire')
            ->setPseudo('Decoupeuse')
            ->setGender(1)
            ->setBirthdate(new DateTime(1951 - 10 - 01))
            ->setAddress($faker->paragraph(1))
            ->setZipcode('69001')
            ->setCountry($faker->randomElement($countries))
            ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($userAdmin);
        $users[] = $userAdmin;

        $userRegular = new User();
        $userRegular->setEmail('toto@gmail.com')
            ->setPassword($this->hash->hashPassword($userAdmin, 'toto'))
            ->setFirstname('toto')
            ->setLastname('toto')
            ->setPseudo('toto')
            ->setGender(2)
            ->setBirthdate(new DateTime(1987 - 01 - 28))
            ->setAddress($faker->paragraph(1))
            ->setZipcode('69006')
            ->setCountry($faker->randomElement($countries));
        $manager->persist($userRegular);
        $users[] = $userRegular;

        for ($i = 0; $i < self::NBNFT; $i++) {
            $nft = new NFT();
            $nft->setName($faker->word())
                ->setImg($faker->url())
                ->setExistingNumber($faker->numberBetween(1, 10))
                ->setLaunchDate(new DateTime($faker->date()))
                ->setLaunchPriceEth($faker->randomFloat(0.1, 2))
                ->setLaunchPriceEur($faker->randomFloat(0.1, 2))
                ->setCollection($faker->randomElement($collectionsNft))
                ->setUser($faker->randomElement($users))
                ->setDescription($faker->paragraph(1))
                ->addCategory($faker->randomElement($categories))
                ->setCreator($faker->name());
            $manager->persist($nft);
        };


        $manager->flush();
    }
}
