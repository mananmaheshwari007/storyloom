<?php

namespace App\Support;

class Contact
{
    /** The number shipped as a placeholder — never a real destination. */
    public const PLACEHOLDER = '919999999999';

    /** Storyloom operates from India, so bare local numbers get +91. */
    private const DEFAULT_COUNTRY_CODE = '91';

    /**
     * The WhatsApp number in the only format wa.me accepts: digits, country
     * code included, nothing else.
     *
     * Editors save numbers however they were given them — "+91 87408 53131",
     * "8740853131", "091-87408-53131". wa.me silently fails on all of those, and
     * a ten-digit Indian mobile without its country code is read as some other
     * country entirely, so the chat opens to nobody. This normalises rather than
     * trusting the field.
     *
     * @return string|null  null when unset or still the placeholder
     */
    public static function whatsappNumber(): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) setting('contact_whatsapp', ''));

        if ($digits === '') {
            return null;
        }

        // Leading zeros are a domestic dialling habit, not part of the number.
        $digits = ltrim($digits, '0');

        // Ten digits starting 6–9 is an Indian mobile missing its country code.
        if (strlen($digits) === 10 && preg_match('/^[6-9]/', $digits)) {
            $digits = self::DEFAULT_COUNTRY_CODE . $digits;
        }

        return $digits === self::PLACEHOLDER ? null : $digits;
    }

    /**
     * The full wa.me link, with the opening message pre-typed.
     *
     * @return string|null  null when there is no usable number to link to
     */
    public static function whatsappLink(): ?string
    {
        $number = self::whatsappNumber();

        if ($number === null) {
            return null;
        }

        $url = 'https://wa.me/' . $number;
        $prefill = trim((string) setting('whatsapp_prefill', 'Hi Storyloom — I would like to begin a story.'));

        return $prefill === '' ? $url : $url . '?text=' . rawurlencode($prefill);
    }
}
