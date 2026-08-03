<?php

namespace App\Services\Surat;

use App\Models\MasterPlaceholder;

class PlaceholderService
{
    /**
     * Extract all {{key}} placeholders from an HTML string.
     *
     * @return array<string> List of placeholder strings e.g. ['{{nama}}', '{{nik}}']
     */
    public function extractPlaceholders(string $html): array
    {
        preg_match_all('/\{\{([a-z_]+)\}\}/', $html, $matches);

        return array_unique($matches[0]);
    }

    /**
     * Validate that all placeholders in the HTML are registered in master_placeholders.
     *
     * @return array<string> List of invalid/unregistered placeholders
     */
    public function validatePlaceholders(string $html): array
    {
        $found = $this->extractPlaceholders($html);

        if (empty($found)) {
            return [];
        }

        $registered = MasterPlaceholder::pluck('placeholder')->toArray();

        return array_values(array_diff($found, $registered));
    }

    /**
     * Replace all {{key}} placeholders in the HTML with values from the data array.
     *
     * @param  array<string, string>  $data  Keys are placeholder keys (without braces), e.g. ['nama' => 'Budi']
     */
    public function replacePlaceholders(string $html, array $data): string
    {
        foreach ($data as $key => $value) {
            $html = str_replace('{{'.$key.'}}', $value ?? '', $html);
        }

        return $html;
    }

    /**
     * Check if the HTML still contains any unreplaced placeholders.
     */
    public function hasUnreplacedPlaceholders(string $html): bool
    {
        return (bool) preg_match('/\{\{[a-z_]+\}\}/', $html);
    }

    /**
     * Get remaining unreplaced placeholder keys from an HTML string.
     *
     * @return array<string>
     */
    public function getRemainingPlaceholders(string $html): array
    {
        preg_match_all('/\{\{([a-z_]+)\}\}/', $html, $matches);

        return array_unique($matches[1]);
    }

    /**
     * Build form fields metadata from placeholder keys in the HTML.
     * Merges with MasterPlaceholder labels for user-friendly display.
     *
     * @return array<array{key: string, label: string, placeholder_raw: string}>
     */
    public function buildFormFields(string $html): array
    {
        $keys = $this->getRemainingPlaceholders($html);

        $masterMap = MasterPlaceholder::whereIn('placeholder', array_map(
            fn ($key) => '{{'.$key.'}}',
            $keys
        ))->pluck('nama_field', 'placeholder')->toArray();

        return array_map(function (string $key) use ($masterMap): array {
            $placeholder = '{{'.$key.'}}';

            return [
                'key' => $key,
                'label' => $masterMap[$placeholder] ?? ucfirst(str_replace('_', ' ', $key)),
                'placeholder_raw' => $placeholder,
            ];
        }, $keys);
    }
}
