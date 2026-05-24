<?php

namespace App\Twig;

use App\Repository\WebsiteSettingsRepository;

class AppGlobal
{
    public function __construct(
        private WebsiteSettingsRepository $settingsRepository
    ) {}

    public function getSettings()
    {
        return $this->settingsRepository->findOneBy([]);
    }
}
