<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Feature;
use App\Entity\FeatureValue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FeatureFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $features = [
            [
                "name" => "Couleur",
                "type" => "options",
                "options" => [
                    "Blanc",
                    "Noir",
                    "Vert",
                    "Jeune",
                    "Orange",
                    "Bleu",
                    "Rouge",
                    "Rose",
                    "Marron",
                    "Argent",
                    "Multicouleur"
                ]
            ],
            [
                "name" => "Taille",
                "type" => "options",
                "options" => [
                    "XS",
                    "S",
                    "M",
                    "L",
                    "XL",
                    "TU"
                ],
                "categories" => [CategoryFixtures::CAP, CategoryFixtures::GLOVES, CategoryFixtures::HELMET, CategoryFixtures::TSHIRT, CategoryFixtures::JACKET, CategoryFixtures::ACCESSORY]
            ],
            [
                "name" => "Poids",
                "type" => "free",
                "categories" => [CategoryFixtures::MOTO, CategoryFixtures::HELMET]
            ]
        ];

        foreach ($features as $f) {
            $feature = new Feature();
            $feature->setName($f["name"]);
            $feature->setType($f['type']);
            if (isset($f['categories'])) {
                $categoryRepository = $manager->getRepository(Category::class);
                foreach ($f["categories"] as $ref) {
                    $category = $this->getReference($ref, Category::class);
                    $feature->addCategory($category);
                }
            }
            if ($f['type'] == "options" && $f["options"]) {
                foreach ($f["options"] as $option) {
                    $fo = new FeatureValue();
                    $fo->setValue($option);
                    $feature->addOption($fo);
                }
            }
            $manager->persist($feature);
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
