<?php

namespace App\Services;

class FeatureValueMapper
{
    public const COLORS = [
        'Rouge' => 'Red',
        'Bleu' => 'Blue',
        'Jeune' => 'Yellow',
        'Noir' => 'Black',
        "Blanc" => "White",
        "Marron" => "Brown",
        "Argent" => "Silver",
        "Vert" => "Green",
        "Rose" => "Pink",
        "Multicouleur" => "Multicolor"
    ];

    public function mapColor(string $value): string
    {
        return self::COLORS[$value] ?? $value;
    }
}
