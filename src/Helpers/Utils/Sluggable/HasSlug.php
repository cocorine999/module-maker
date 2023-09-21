<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable;

use Illuminate\Database\Eloquent\Model;
use LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable\SlugOptions;

trait HasSlug
{
    /**
     * Boot the HasSlug trait for a model.
     */
    public static function bootHasSlug()
    {
        static::creating(function (Model $model) {
            $model->generateSlugOnCreate($model);
        });

        static::updating(function (Model $model) {
            $model->generateSlugOnUpdate($model);
        });
    }

    /**
     * Generate and set a unique slug for the model when it's created.
     */
    public function generateSlugOnCreate(Model $model)
    {

        $this->generateAndSetSlug($model);
    }

    /**
     * Generate and set a unique slug for the model when it's updated.
     */
    public function generateSlugOnUpdate(Model $model)
    {
        if ($this->getSlugOptions()->getOnUpdate()) {
            $this->generateAndSetSlug($model);
        }
    }

    protected function generateAndSetSlug(Model $model)
    {
        if ($this->getSlugOptions()->iSlugOnEmpty() && !$this->getAttribute($this->getSlugOptions()->getSlugAttribute())) {
            $slug = $this->generateUniqueSlug($this->getSlugOptions()->getSource(), $model);
            $this->setAttribute($this->getSlugOptions()->getSlugAttribute(), $slug);
        }
    }

    /**
     * Get the slug options for the model.
     *
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                    ->generateSlugsFrom(['name'])
                    ->saveSlugsTo('slug')
                    ->separator('_')
                    ->slugColumnsMapping()
                    ->enableSlugOnEmpty();
    }

    /**
     * Generate a unique slug based on the provided source attributes.
     *
     * @param array $sourceAttributes
     * @return string
     */
    protected function generateUniqueSlug(array $sourceAttributes, Model $model): string
    {
        $slug = $this->getSlugOptions()->generateUniqueSlug($sourceAttributes, $model);

        return $slug;
    }

    /**
     * Generate a slug from the given source attributes.
     *
     * @param array $sourceAttributes
     * @return string
     */
    /* protected function generateSlugFromAttributes(array $sourceAttributes): string
    {
        // Implement your custom slug generation logic here.
        // You can use the SlugOptions and source attributes to generate the slug.

        // Example implementation:
        // $slug = // Your logic to generate the slug here.

        // You can also use a custom slug generator if provided.
        $customSlugGenerator = $this->getSlugOptions()->getCustomSlugGenerator();
        if ($customSlugGenerator && is_callable($customSlugGenerator)) {
            $slug = call_user_func($customSlugGenerator, $sourceAttributes);
        }

        return $slug;
    } */

    /**
     * Make the generated slug unique by appending a suffix if necessary.
     *
     * @param string $slug
     * @param int $suffix
     * @return string
     */
    protected function makeSlugUnique(string $slug, Model $model, int $suffix = 1): string
    {
        $maxAttempts = $this->getSlugOptions()->getMaxAttempts();
        while ($this->getSlugOptions()->isSlugExistsInDatabase($slug, $model) || $this->getSlugOptions()->isSlugReserved($slug)) {
            if ($suffix >= $maxAttempts) {
                throw new \RuntimeException("Maximum number of attempts reached to generate a unique slug.");
            }
            $slug = $slug . $this->getSlugOptions()->getUniqueSuffixSeparator() . $suffix++;
        }

        return $slug;
    }

    /**
     * Check if a slug exists in the database for the model.
     *
     * @param string $slug
     * @return bool
     */
    protected function slugExistsInDatabase(string $slug): bool
    {
        $slugAttribute = $this->getSlugOptions()->getSlugAttribute();
        return static::where($slugAttribute, $slug)
            ->where('id', '<>', $this->getKey())
            ->exists();
    }

    /**
     * Check if a slug is reserved.
     *
     * @param string $slug
     * @return bool
     */
    protected function slugIsReserved(string $slug): bool
    {
        return in_array($slug, $this->getSlugOptions()->getReservedWords());
    }
}