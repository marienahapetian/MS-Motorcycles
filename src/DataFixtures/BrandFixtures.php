<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $brands = [
            [
                "name" => "Harley-Davidson",
                "categories" => [CategoryFixtures::MOTO]
            ],
            [
                "name" => "Yamaha",
                "categories" => [CategoryFixtures::MOTO]
            ],
            [
                "name" => "Suzuki",
                "categories" => [CategoryFixtures::MOTO]
            ],
            [
                "name" => "Honda",
                "categories" => [CategoryFixtures::MOTO]
            ],
            [
                "name" => "Kawasaki",
                "categories" => [CategoryFixtures::MOTO]
            ]
        ];

        foreach ($brands as $brand) {
            $b = new Brand();
            $b->setName($brand['name']);

            foreach ($brand["categories"] as $categoryRef) {
                $category = $this->getReference($categoryRef, Category::class);
                $b->addCategory($category);
            }

            $manager->persist($b);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
