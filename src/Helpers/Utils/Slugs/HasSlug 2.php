<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable;


use Illuminate\Support\Str;
use LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable\SlugOptions;

trait HasSlugs
{
    protected static function bootHasSlug()
    {
        static::creating(function ($model) {
            if (!$model->getSlugSource()) {
                throw new \RuntimeException('The $slugSource property must be defined in the model.');
            }

            if (!$model->getSlugOptions()) {
                throw new \RuntimeException('The $slugOptions property must be defined in the model.');
            }

            if (!$model->generateSlugOnEmpty() && empty($model->{$model->getSlugAttribute()})) {
                $model->{$model->getSlugAttribute()} = $model->generateSlug();
            }
        });

        static::updating(function ($model) {
            if ($model->getSlugOptions()->getOnUpdate()) {
                $model->{$model->getSlugAttribute()} = $model->generateSlug();
            }
        });
    }

    public function generateSlug(): string
    {
        $slugOptions = $this->getSlugOptions();

        $sourceAttributes = $this->getSlugSourceAttributes();
        $slugValues = [];

        foreach ($sourceAttributes as $attribute) {
            $slugValues[] = $this->{$attribute};
        }

        $slugGenerator = $slugOptions->getCustomSlugGenerator() ?? function (array $sourceAttributes) use ($slugOptions) {
            $separator = $slugOptions->getSeparator();
            $slug = implode($separator, $sourceAttributes);

            if ($slugOptions->getRemoveSpecialCharacters()) {
                $slug = Str::slug($slug, $separator);
            }

            if ($slugOptions->getRemoveAccents()) {
                $slug = Str::ascii($slug);
            }

            if ($slugOptions->getUseUppercase()) {
                $slug = strtoupper($slug);
            } else {
                $slug = strtolower($slug);
            }

            return $slug;
        };

        $slug = $slugGenerator($slugValues);

        if ($slugOptions->getUnique()) {
            $slug = $this->makeSlugUnique($slug);
        }

        if ($slugOptions->getMaxLength() !== null) {
            $slug = $this->truncateSlug($slug, $slugOptions->getMaxLength(), $slugOptions->getKeepWords());
        }

        return $slug;
    }

    protected function truncateSlug(string $slug, int $maxLength, bool $keepWords): string
    {
        if (mb_strlen($slug) <= $maxLength) {
            return $slug;
        }

        if ($keepWords) {
            $slug = mb_substr($slug, 0, $maxLength);
            $slug = mb_substr($slug, 0, mb_strrpos($slug, $this->getSlugOptions()->getSeparator()));
        } else {
            $slug = mb_substr($slug, 0, $maxLength);
        }

        return $slug;
    }

    protected function makeSlugUnique(string $slug): string
    {
        $maxAttempts = $this->getSlugOptions()->getMaxAttempts();
        $originalSlug = $slug;
        $suffix = 1;

        while ($this->slugExistsInDatabase($slug) || $this->slugIsReserved($slug)) {
            if ($suffix >= $maxAttempts) {
                throw new \RuntimeException("Maximum number of attempts reached to generate a unique slug.");
            }

            $slug = $originalSlug . $this->getSlugOptions()->getUniqueSuffixSeparator() . $suffix;
            $suffix++;
        }

        return $slug;
    }

    protected function slugExistsInDatabase(string $slug): bool
    {
        $slugColumn = $this->getSlugOptions()->getSlugColumnsMapping()->getDatabaseColumn();
        $query = static::where($slugColumn, $slug);

        if ($this->getKey()) {
            $query->where($this->getKeyName(), '<>', $this->getKey());
        }

        return $query->exists();
    }

    protected function slugIsReserved(string $slug): bool
    {
        $reservedWords = $this->getSlugOptions()->getReservedWords();
        return in_array($slug, $reservedWords);
    }

    protected function getSlugOptions(): SlugOptions
    {
        return $this->slugOptions ?? SlugOptions::create();
    }

    protected function getSlugSourceAttributes(): array
    {
        $slugSource = $this->getSlugSource();
        if (is_string($slugSource)) {
            return [$slugSource];
        } elseif (is_array($slugSource)) {
            return $slugSource;
        } else {
            throw new \RuntimeException('Invalid $slugSource property in the model.');
        }
    }

    protected function getSlugSource(): string|array
    {
        return $this->slugSource ?? [];
    }

    public function getSlugAttribute(): string
    {
        return $this->getSlugOptions()->getSlugAttribute();
    }

    public function generateSlugOnEmpty(): bool
    {
        return $this->getSlugOptions()->getGenerateSlugOnEmpty();
    }
}
