<?php

namespace App\DataFixtures;

use App\Entity\WebsiteSettings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WebsiteSettingsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $settings = new WebsiteSettings();

        $settings->setFont('\'Montserrat\', sans-serif');
        $settings->setInstagramLink('msmotorcycles64');
        $settings->setFacebookLink('Ms-Motorcycles-64-61565209926614'); // typo in entity but OK
        $settings->setTiktokLink('ms.motorcycles.64');

        $settings->setAccentColor('#DB362C');
        $settings->setBlackColor('#323232');
        $settings->setWhiteColor('#FFFFFF');

        $settings->setLocation('<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2902.674750591449!2d-0.435683824457153!3d43.321067671119714!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd564f06a4058d01%3A0x5f23de009965d82b!2sMs%20Motorcycles!5e0!3m2!1sen!2sfr!4v1775683633324!5m2!1sen!2sfr" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>');
        $settings->setAddress('4 Rue Bernard Palissy, 64230 Lescar');
        $settings->setPhone('0668457549');
        $settings->setEmail('msmotorcycles@gmail.com');

        $manager->persist($settings);
        $manager->flush();
    }
}
