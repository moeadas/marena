<?php

if (!function_exists('marena_assets')) {
    /**
     * Return asset path with optional versioning query string.
     *
     * @param  string  $path
     * @return string
     */
    function marena_assets(string $path): string
    {
        $filePath = public_path($path);

        if (file_exists($filePath)) {
            $version = '?v=' . filemtime($filePath);
        } else {
            $version = '';
        }

        return asset($path) . $version;
    }
}

if (!function_exists('format_date')) {
    /**
     * Format a date with localized formatting.
     *
     * @param  \DateTime|string|null  $date
     * @param  string  $format
     * @param  string  $locale
     * @return string|null
     */
    function format_date($date, string $format = 'd/m/Y', string $locale = 'fr_FR'): ?string
    {
        if (!$date) {
            return null;
        }

        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }

        try {
            $currentLocale = \Carbon\Carbon::getLocale();
            \Carbon\Carbon::setLocale($locale);
            $formatted = $date->translatedFormat($format);
            \Carbon\Carbon::setLocale($currentLocale);

            return $formatted;
        } catch (\Throwable $e) {
            return $date->format($format);
        }
    }
}

if (!function_exists('role_label')) {
    /**
     * Return human-readable role label.
     *
     * @param  string  $role
     * @return string
     */
    function role_label(string $role): string
    {
        $labels = [
            'admin'             => 'Administrateur',
            'beneficiary'       => 'Bénéficiaire',
            'caregiver'         => 'Aidant',
            'provider'          => 'Intervenant',
            'company_manager'   => 'Gestionnaire de structure',
            'employee'          => 'Salarié',
        ];

        return $labels[$role] ?? ucfirst(str_replace('_', ' ', $role));
    }
}

if (!function_exists('funding_label')) {
    /**
     * Return human-readable funding type label.
     *
     * @param  string  $type
     * @return string
     */
    function funding_label(string $type): string
    {
        $labels = [
            'state_funded'         => 'Pris en charge par l\'État',
            'partially_reimbursed' => 'Partiellement remboursé',
            'beneficiary_paid'     => 'À charge du bénéficiaire',
            'mixed'                => 'Financement mixte',
            'retirement_fund'      => 'Caisse de retraite',
            'to_be_assessed'       => 'À évaluer',
        ];

        return $labels[$type] ?? ucfirst(str_replace('_', ' ', $type));
    }
}