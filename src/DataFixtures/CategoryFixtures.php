<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const MOTO = 'category_moto';
    public const HELMET = 'category_helmet';
    public const CAP = 'category_cap';
    public const JACKET = 'category_jacket';
    public const TSHIRT = 'category_tshirt';
    public const GLOVES = 'category_gloves';
    public const ACCESSORY = 'category_accessory';
    public function load(ObjectManager $manager): void
    {
        $categories = [
            self::MOTO => "Motos",
            self::HELMET => "Casques de moto",
            self::CAP => "Casquettes",
            self::JACKET => "Vestes",
            self::TSHIRT => "T-Shirts",
            self::GLOVES => "Gants",
            self::ACCESSORY => "Accessoires",
        ];

        foreach ($categories as $ref => $category) {
            $c = new Category();
            $c->setName($category);
            $manager->persist($c);
            $this->addReference($ref, $c);
        }
        $manager->flush();
    }
}
