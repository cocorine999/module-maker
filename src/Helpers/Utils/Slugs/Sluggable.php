<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


/**
 * Trait Sluggable
 *
 * The `Sluggable` trait automatically generates slugs for model instances based on certain attributes.
 *
 * @package LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable
 */
trait Sluggable
{
    /**
     * Get the configuration options for the Sluggable trait.
     *
     * @return SluggableOptions
     */
    public function getSlugOptions(): SluggableOptions
    {
        return SluggableOptions::create()
            ->generateSlugsFrom(['name'])
            ->saveSlugsTo('slug')
            ->separator('_');
    }

    /**
     * Boot the Sluggable trait for the model.
     *
     * @return void
     */
    public static function bootSluggable(): void
    {
        static::creating(function (Model $model) {
            if ($model->hasSlugAttribute() && $model->shouldGenerateSlug()) {
                $model->generateSlug();
            }
        });

        static::updating(function (Model $model) {
            if ($model->getOnUpdate() && $model->hasSlugAttribute() && $model->shouldGenerateSlug()) {
                $model->generateSlug();
            }
        });
    }

    /**
     * Determine if the model has a slug attribute.
     *
     * @return bool
     */
    protected function hasSlugAttribute(): bool
    {
        return property_exists($this, $this->sluggableOptions()->slugAttribute);
    }

    /**
     * Determine if the slug should be generated for the model.
     *
     * @return bool
     */
    protected function shouldGenerateSlug(): bool
    {
        $slugAttribute = $this->{$this->sluggableOptions()->slugAttribute};

        return empty($slugAttribute);
    }

    /**
     * Generate the slug and set it on the model.
     *
     * @return void
     */
    protected function generateSlug(): void
    {
        $options = $this->sluggableOptions();

        $generatedSlug = $options->slugColumnsMapping->generateSlug($this);

        if ($options->getMaxLength()) {
            $generatedSlug = Str::limit($generatedSlug, $options->getMaxLength());
        }

        if ($options->unique && !empty($generatedSlug)) {
            $generatedSlug = $this->makeUniqueSlug($generatedSlug);
        }

        if($options->isSlugReserved())
            $generatedSlug = $options->slugColumnsMapping->generateSlug($this);

        $this->{$options->slugAttribute} = $generatedSlug;

    }

    /**
     * Make the generated slug unique by appending a suffix.
     *
     * @param string $slug
     * @param int $suffix
     * @return string
     */
    protected function makeUniqueSlug(string $slug, int $suffix = 0): string
    {
        $options = $this->sluggableOptions();

        if ($suffix > 0) {
            $suffixSeparator = $options->getSeparator();
            $slug .= $suffixSeparator . $suffix;
        }

        if ($options->unique) {
            $query = static::where($options->slugAttribute, '=', $slug);

            if ($this->slugExists($slug)) {
                $query->whereKeyNot($this->getKey());
            }

            $suffix++;

            return $this->makeUniqueSlug($slug, $suffix);
        }

        return $slug;
    }

    /**
     * Check if the slug already exists in the database.
     *
     * @param  string  $slug
     * @return bool
     */
    protected function slugExists($slug): bool
    {
        return static::where($this->sluggableOptions()->getSaveTo(), $slug)
            ->when($this->exists, function ($query) {
                $query->where('id', '!=', $this->id);
            })
            ->exists();
    }

}
