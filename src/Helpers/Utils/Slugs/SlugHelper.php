<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable;


/**
 * Class SlugHelper
 *
 * The `SlugHelper` class provides helper methods for slug sanitization.
 *
 * @package LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable
 */
class SlugHelper
{
    
    /**
     * Sanitize the generated slug to ensure it's safe for URLs.
     *
     * @param string $slug The generated slug.
     * @param string $separator The slug separator.
     * @return string The sanitized slug.
     */
    public static function sanitizeSlug(string $slug, string $separator): string
    {
        // Replace spaces and other non-word characters with the separator
        $slug = preg_replace('/[^\p{L}\p{N}_-]+/u', $separator, $slug);

        // Remove duplicate separators
        $slug = preg_replace('/' . preg_quote($separator, '/') . '{2,}/', $separator, $slug);

        // Trim separators from the beginning and end of the slug
        $slug = trim($slug, $separator);

        // Convert the slug to lowercase
        $slug = mb_strtolower($slug, 'UTF-8');

        return $slug;
    }
}