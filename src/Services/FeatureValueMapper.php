<?php

namespace App\Services;

class FeatureValueMapper
{
    public const COLORS = [
        'Rouge' => 'Red',
        'Bleu' => 'Blue',
        'Jeune' => 'Yellow',
        'Noir' => 'Black',
    ];

    public function mapColor(string $value): string
    {
        return self::COLORS[$value] ?? $value;
    }
}
