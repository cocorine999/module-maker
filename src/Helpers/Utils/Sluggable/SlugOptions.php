<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable;

use Closure;
use Illuminate\Database\Eloquent\Model;
use LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable\SlugColumnsMapping;

/**
 * Class SlugOptions
 *
 * The `SlugOptions` class provides options and configuration settings for the Sluggable trait.
 * The Sluggable trait is used to generate slugs for model instances based on certain attributes.
 *
 * @package LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable
 */
class SlugOptions
{

    /**
     * The attribute name that will be used to store the generated slug.
     *
     * @var string
     */
    protected $slugAttribute;

    /**
     * The attribute name(s) used to generate the slug. This can be a string for a single attribute
     * or an array of attribute names if the slug needs to be generated based on multiple attributes.
     *
     * @var string|string[]
     */
    protected $source;

    /**
     * The separator character to use in the generated slug. Default is '-'.
     *
     * @var string
     */
    protected $separator = '-';

    /**
     * The language used for slug transliteration.
     *
     * @var string
     */
    protected $language = 'en';

    /**
     * Whether the slug should be updated automatically when source attributes change.
     *
     * @var bool
     */
    protected $onUpdate = true;

    /**
     * The maximum length of the generated slug. If set, the slug will be truncated to this length.
     * Note that the unique identifier, if added, will not be included in the length calculation.
     * Set to null for unlimited length.
     *
     * @var int|null
     */
    protected $maxLength = null;

    /**
     * Whether to keep whole words when truncating the slug based on the max length.
     *
     * @var bool
     */
    protected $keepWords = true;

    /**
     * Whether to force the slug to be unique. If true, it will append a unique identifier
     * to the slug if there are any conflicts.
     *
     * @var bool
     */
    protected $unique = true;

    /**
     * The suffix to be added to the slug if a duplicate is found.
     *
     * @var string|null
     */
    protected $uniqueSuffix = null;

    /**
     * The maximum number of attempts to make the slug unique by appending a unique identifier.
     * This option is only applicable if `$unique` is set to true. If the maximum number of attempts
     * is reached, the system will throw an exception to prevent an infinite loop.
     *
     * @var int
     */
    protected $maxAttempts = 128;

    /**
     * The callback function used to generate the slug from the source attribute(s).
     * This allows you to customize the slug generation process by providing your own
     * logic to generate the slug.
     *
     * The callback function should accept an array of source attribute values as the argument
     * and return the generated slug.
     *
     * Example:
     * ```
     * protected function customSlugGenerator(array $sourceAttributes): string
     * {
     *     // Your custom logic to generate the slug based on source attributes
     * }
     * ```
     *
     * @var callable|null
     */
    protected $customSlugGenerator = null;

    /**
     * The attribute from which the slug is generated.
     *
     * @var string
     */
    protected string $sourceAttribute = 'title';   

    /**
     * The callback function to handle slug collisions and generate a unique slug.
     * This callback is executed when a slug conflict is detected to generate a new unique slug.
     * It receives the base slug (slug without the suffix) and the current suffix number to be added.
     * The callback should return the unique slug with the suffix.
     *
     * @var \Closure|null
     */
    protected $handleSlugCollisionUsing = null;

    /**
     * The callback function to regenerate the slug when the source attributes change.
     * This callback is executed when the source attributes are updated to regenerate the slug.
     * It receives the model instance as the argument and should handle the slug regeneration logic.
     *
     * @var callable|null
     */
    protected $regenerateSlugUsing = null;

    /**
     * The callback function to customize the final formatting of the generated slug.
     * This callback is executed after the slug is generated and can be used to apply
     * additional formatting or modifications to the slug.
     *
     * The callback function should accept the generated slug as the argument and
     * return the formatted slug.
     *
     * Example:
     * ```
     * protected function customSlugFormatter(string $generatedSlug): string
     * {
     *     // Your custom formatting logic for the slug
     * }
     * ```
     *
     * @var \Closure|null
     */
    protected $slugFormatter = null;

    /**
     * Whether to allow overriding an existing slug with a new slug.
     *
     * @var bool
     */
    protected bool $allowSlugOverride = false;

    /**
     * An array of reserved words that should not be used as slugs.
     * If a reserved word is detected as the slug, it will be suffixed with a unique identifier to make it unique.
     *
     * @var array
     */
    protected $reservedWords = [];

    /**
     * An array of slugs that are blacklisted and should not be generated.
     * If a blacklisted slug is detected, it will be suffixed with a unique identifier to make it unique.
     *
     * @var array|null
     */
    protected $slugBlacklist = [];

    /**
     * An array of slugs that are whitelisted and can be generated.
     * If a whitelist is defined, any slug not present in the whitelist will not be generated.
     *
     * @var array|null
     */
    protected $slugWhitelist = [];

    /**
     * The strategy for generating the slug. This property determines how the slug is generated.
     * The possible values for this property depend on the implementation and can be customized.
     *
     * @var string
     */
    protected $slugGeneratorStrategy = 'title';

    /**
     * The maximum length of the generated slug without truncating words.
     * If set, the slug will be truncated to this length without breaking words.
     *
     * @var string
     */
    protected string $maxLengthKeepWords = 'default';

    /**
     * Whether to use uppercase letters in the generated slug.
     *
     * @var bool
     */
    protected bool $useUppercase = false;

    /**
     * Whether to remove special characters from the generated slug.
     *
     * @var bool
     */
    protected bool $removeSpecialCharacters = true;

    /**
     * Whether to remove accents from the generated slug.
     *
     * @var bool
     */
    protected bool $removeAccents = true;

    /**
     * The prefix to be added to the slug.
     *
     * @var string
     */
    protected string $slugWithPrefix = '';

    /**
     * The suffix to be added to the slug.
     *
     * @var string
     */
    protected string $slugWithSuffix = '';

    /**
     * Whether to use only lowercase letters in the generated slug.
     *
     * @var bool
     */
    protected bool $slugWithLowercase = false;

    /**
     * Whether to use only alphanumeric characters in the generated slug.
     *
     * @var bool
     */
    protected bool $slugWithNumbers = false;

    /**
     * Whether to use an underscore (_) in the generated slug.
     *
     * @var bool
     */
    protected bool $slugWithUnderscore = false;

    /**
     * The separator to be used when appending the unique suffix to duplicate slugs.
     *
     * @var string
     */
    protected string $uniqueSuffixSeparator = '-';

    /**
     * Whether to generate the slug only if the target attribute is empty.
     *
     * @var bool
     */
    protected bool $generateSlugOnEmpty = true;

    /**
     * A regular expression pattern to allow specific characters in the generated slug.
     * This pattern defines the allowed characters in the slug.
     *
     * @var string|null
     */
    protected ?string $allowCharacters = null;

    /**
     * Whether to force regenerate the slug even if the source attributes have not changed.
     *
     * @var bool
     */
    protected $forceRegenerate = false;

    /**
     * The mapping between source attributes and their corresponding slug column names.
     *
     * @var SlugColumnsMapping
     */
    protected $slugColumnsMapping;

    /**
     * Whether to preserve uppercase letters in the generated slug.
     *
     * @var bool
     */
    protected $preserveUppercase = false;

    /**
     * The custom callable function used for generating the slug.
     *
     * @var \Closure|null
     */
    protected $slugUsing = null;

    /**
     * A callback to transform the generated slug.
     *
     * @var \Closure|null
     */
    protected $slugTransformCallback = null;

    /**
     * A callback function that will be called before generating the slug.
     *
     * @var callable|null
     */
    protected $beforeSlugGeneration = null;

    /**
     * A callback function that will be called after generating the slug.
     *
     * @var callable|null
     */
    protected $afterSlugGeneration = null;

    /**
     * Additional options for the slug engine.
     *
     * @var array
     */
    protected $slugEngineOptions = [];

    /**
     * Get the options for slug generation.
     *
     * @return SlugOptions
     */
    public static function create(): SlugOptions
    {
        return new static();
    }

    protected function getSlugOptions(): self
    {
        return SlugOptions::create()
                ->generateSlugsFrom(['name'])
                ->saveSlugsTo('slug')
                ->separator('-')
                ->language('en')
                ->unique()
                ->slugColumnsMapping()
                ->enableSlugOnEmpty()
                ->maxLength(100);
    }

    public function build(): array
    {
        // Add validation logic here if needed.

        return get_object_vars($this);
        return [
            'slug_attribute' => $this->slugAttribute,
            'source' => $this->source,
            'separator' => $this->separator,
            'language' => $this->language,
            'on_update' => $this->onUpdate,
            'max_length' => $this->maxLength,
            'keep_words' => $this->keepWords,
            'unique' => $this->unique,
            'unique_suffix' => $this->uniqueSuffix,
            'max_attempts' => $this->maxAttempts,
            'handle_slug_collision_using' => $this->handleSlugCollisionUsing,
            'regenerate_slug_using' => $this->regenerateSlugUsing,
            'slug_columns_mapping' => $this->slugColumnsMapping,
            'slug_blacklist' => $this->slugBlacklist,
            'slug_whitelist' => $this->slugWhitelist,
            'slug_engine_options' => $this->slugEngineOptions,
            'unique_suffix_separator' => $this->uniqueSuffixSeparator,
            'preserve_uppercase' => $this->preserveUppercase,
            'generate_slug_on_empty' => $this->generateSlugOnEmpty,
            'allow_characters' => $this->allowCharacters,
            'slug_transform_callback' => $this->slugTransformCallback,
            'before_slug_generation' => $this->beforeSlugGeneration,
            'after_slug_generation' => $this->afterSlugGeneration,
            'use_uppercase' => $this->useUppercase,
            'remove_special_characters' => $this->removeSpecialCharacters,
            'remove_accents' => $this->removeAccents,
            'slug_with_prefix' => $this->slugWithPrefix,
            'slug_with_suffix' => $this->slugWithSuffix,
            'slug_with_lowercase' => $this->slugWithLowercase,
            'slug_with_numbers' => $this->slugWithNumbers,
            'slug_with_underscore' => $this->slugWithUnderscore,
            'slug_using' => $this->slugUsing,
        ];
    }

    /**
     * Set the attributes from which the slug should be generated.
     *
     * @param array $attributes
     * @return $this
     */
    public function generateSlugsFrom(array $attributes): self
    {
        $this->source = $attributes;
        return $this;
    }

    /**
     * Set the attribute where the generated slug will be saved.
     *
     * @param string $attribute
     * @return $this
     */
    public function saveSlugsTo(string $attribute): self
    {
        $this->slugAttribute = $attribute;
        return $this;
    }

    /**
     * Set the character used to separate words in the slug.
     *
     * @param string $separator
     * @return $this
     */
    public function separator(string $separator): self
    {
        $this->separator = $separator;
        return $this;
    }

    /**
     * Set the language used for slug transliteration.
     *
     * @param string $language
     * @return $this
     */
    public function language(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Set whether the slug should be updated automatically when source attributes change.
     *
     * @param bool $onUpdate
     * @return $this
     */
    public function onUpdate(bool $onUpdate): self
    {
        $this->onUpdate = $onUpdate;
        $this->allowSlugOverride = $onUpdate;
        return $this;
    }

    /**
     * Set the maximum length of the generated slug.
     *
     * @param int|null $maxLength
     * @return $this
     */
    public function maxLength(int $maxLength = 128): self
    {
        $this->maxLength = $maxLength;
        return $this;
    }

    /**
     * Set whether to keep whole words when truncating the slug based on the max length.
     *
     * @param bool $keepWords
     * @return $this
     */
    public function keepWords(bool $keepWords): self
    {
        $this->keepWords = $keepWords;
        return $this;
    }

    /**
     * Set whether the generated slugs should be unique.
     *
     * @param bool $unique
     * @return $this
     */
    public function unique(bool $unique = true): self
    {
        $this->unique = $unique;
        return $this;
    }

    /**
     * Set the suffix to be added to the slug if a duplicate is found.
     *
     * @param string|null $suffix
     * @return $this
     */
    public function uniqueSuffix(?string $suffix): self
    {
        $this->uniqueSuffix = $suffix;
        return $this;
    }

    /**
     * Set the maximum number of attempts to generate a unique slug when a collision occurs.
     *
     * @param int|null $maxAttempts
     * @return $this
     */
    public function maxSlugAttempts(?int $maxAttempts): self
    {
        $this->maxAttempts = $maxAttempts;
        return $this;
    }

    /**
     * Set the callback function to handle slug collisions and generate a unique slug.
     *
     * @param \Closure $callback
     * @return $this
     */
    public function handleSlugCollisionUsing(\Closure $callback): self
    {
        $this->handleSlugCollisionUsing = $callback;
        return $this;
    }

    /**
     * Set a custom callback for handling slug regeneration logic when the source attributes change.
     *
     * @param callable $regenerateCallback A callable that takes the model instance as input and handles slug regeneration.
     * @return $this
     */
    public function regenerateSlugUsing(callable $regenerateCallback): self
    {
        $this->regenerateSlugUsing = $regenerateCallback;
        return $this;
    }

    /**
     * Set whether to force regenerate the slug even if the source attributes have not changed.
     *
     * @param bool $forceRegenerate
     * @return $this
     */
    public function forceRegenerate(bool $forceRegenerate): self
    {
        $this->forceRegenerate = $forceRegenerate;
        return $this;
    }

    /**
     * Set the mapping between source attributes and their corresponding slug column names.
     *
     * @param array|null $mapping An associative array where keys are source attributes and values are slug column names.
     * @return $this
     */
    public function slugColumnsMapping(array $mapping = null): self
    {
        ///$this->slugColumnsMapping =  new SlugColumnsMapping($this->slugAttribute, $mapping ?? $this->source, $this->separator);
        return $this;
    }

    /**
     * Set a list of blacklisted slugs that should not be generated.
     *
     * @param array $blacklist An array of slugs that should be avoided.
     * @return $this
     */
    public function blacklist(array $blacklist): self
    {
        $this->slugBlacklist = $blacklist;
        return $this;
    }

    /**
     * Add one or more items to the blacklist of slugs that should not be generated.
     *
     * @param string|array $blacklist The slug(s) to be added to the blacklist.
     * @return $this
     */
    public function addToBlacklist(string|array $blacklist): self
    {
        $additionalBlacklist = is_array($blacklist) ? $blacklist : [$blacklist];
        $this->slugBlacklist = array_merge($this->slugBlacklist, $additionalBlacklist);
        return $this;
    }

    /**
     * Set the whitelist of slugs that are allowed to be generated.
     *
     * @param string|array $whitelist The slug(s) that should be allowed in the generation process.
     * @return $this
     */
    public function whitelist(string|array $whitelist): self
    {
        $this->slugWhitelist = is_array($whitelist) ? $whitelist : [$whitelist];
        return $this;
    }

    /**
     * Add one or more items to the whitelist of slugs that are allowed to be generated.
     *
     * @param string|array $whitelist The slug(s) to be added to the whitelist.
     * @return $this
     */
    public function addToWhitelist(string|array $whitelist): self
    {
        $additionalWhitelist = is_array($whitelist) ? $whitelist : [$whitelist];
        $this->slugWhitelist = array_merge($this->slugWhitelist, $additionalWhitelist);
        return $this;
    }

    /**
     * Set the slug engine to be used for generating the slug.
     *
     * @param string $engine
     * @return $this
     */
    public function slugEngine(string $engine): self
    {
        $this->slugEngineOptions['engine'] = $engine;
        return $this;
    }

    /**
     * Set additional options for the slug engine.
     *
     * @param array $options
     * @return $this
     */
    public function slugEngineOptions(array $options): self
    {
        $this->slugEngineOptions['options'] = $options;
        return $this;
    }

    /**
     * Set the separator to be used when appending the unique suffix to duplicate slugs.
     *
     * @param string $uniqueSuffixSeparator
     * @return $this
     */
    public function uniqueSuffixSeparator(string $uniqueSuffixSeparator): self
    {
        $this->uniqueSuffixSeparator = $uniqueSuffixSeparator;
        return $this;
    }

    /**
     * Set whether to preserve uppercase letters in the generated slug.
     *
     * @param bool $preserveUppercase
     * @return $this
     */
    public function preserveUppercase(bool $preserveUppercase): self
    {
        $this->preserveUppercase = $preserveUppercase;
        return $this;
    }

    /**
     * Set whether to generate the slug only if the target attribute is empty.
     *
     * @param bool $generateIfEmpty
     * @return $this
     */
    public function generateSlugOnEmpty(bool $generateIfEmpty): self
    {
        $this->generateSlugOnEmpty = $generateIfEmpty;
        return $this;
    }

    /**
     * Enable the generation of the slug even if the target attribute is empty.
     * By default, the slug generation is skipped if the target attribute is empty.
     *
     * @return $this
     */
    public function enableSlugOnEmpty(): self
    {
        $this->generateSlugOnEmpty = true;
        return $this;
    }

    /**
     * Set a regular expression pattern to allow specific characters in the generated slug.
     *
     * @param string $pattern A regular expression pattern that defines allowed characters.
     * @return $this
     */
    public function allowCharacters(string $pattern): self
    {
        $this->allowCharacters = $pattern;
        return $this;
    }

    /**
     * Set the callback function to customize the slug value.
     *
     * @param \Closure $callback
     * @return $this
     */
    public function callback(\Closure $callback): self
    {
        $this->slugEngineOptions['callback'] = $callback;
        return $this;
    }

    /**
     * Set a callback to transform the generated slug.
     *
     * @param \Closure $callback
     * @return $this
     */
    public function transformSlug(\Closure $callback): self
    {
        $this->slugTransformCallback = $callback;
        return $this;
    }

    /**
     * Set a callback function that will be called before generating the slug.
     *
     * @param callable $callback The callback function to be executed before slug generation.
     * @return $this
     */
    public function beforeSlugGeneration(callable $callback): self
    {
        $this->beforeSlugGeneration = $callback;
        return $this;
    }

    /**
     * Set a callback function that will be called after generating the slug.
     *
     * @param callable $callback The callback function to be executed after slug generation.
     * @return $this
     */
    public function afterSlugGeneration(callable $callback): self
    {
        $this->afterSlugGeneration = $callback;
        return $this;
    }

    /**
     * Set whether to include uppercase letters in the generated slug.
     *
     * @param bool $useUppercase Whether to include uppercase letters. Default is false.
     * @return $this
     */
    public function useUppercase(bool $useUppercase = false): self
    {
        $this->useUppercase = $useUppercase;
        return $this;
    }

    /**
     * Set whether to remove special characters from the generated slug.
     *
     * @param bool $removeSpecialCharacters Whether to remove special characters. Default is true.
     * @return $this
     */
    public function removeSpecialCharacters(bool $removeSpecialCharacters = true): self
    {
        $this->removeSpecialCharacters = $removeSpecialCharacters;
        return $this;
    }

    /**
     * Set whether to remove accents from the generated slug.
     *
     * @param bool $removeAccents Whether to remove accents. Default is true.
     * @return $this
     */
    public function removeAccents(bool $removeAccents = true): self
    {
        $this->removeAccents = $removeAccents;
        return $this;
    }

    /**
     * Set a custom slug formatter using a closure to customize the slug generation.
     *
     * @param \Closure $closure A closure that takes the generated slug as input and returns the formatted slug.
     * @return $this
     */
    public function slugFormatter(Closure $closure): self
    {
        $this->slugFormatter = $closure;
        return $this;
    }

    /**
     * Set whether to allow overriding existing slugs for the same model.
     *
     * @param bool $allow Whether to allow slug override. Default is true.
     * @return $this
     */
    public function allowSlugOverride(bool $allow = true): self
    {
        $this->allowSlugOverride = $allow;
        return $this;
    }

    /**
     * Set a list of reserved words that should not be used as slugs.
     *
     * @param array $words An array of reserved words that should be avoided as slugs.
     * @return $this
     */
    public function reservedWords(array $words): self
    {
        $this->reservedWords = $words;
        return $this;
    }

    /**
     * Add a word to the list of reserved words that should not be used as slugs.
     *
     * @param string $word The word to be added to the reserved words list.
     * @return $this
     */
    public function addReservedWord(string $word): self
    {
        $this->reservedWords[] = $word;
        return $this;
    }

    /**
     * Set the strategy for generating the slug.
     *
     * @param string $strategy The slug generation strategy to be used.
     * @return $this
     */
    public function slugGeneratorStrategy(string $strategy): self
    {
        $this->slugGeneratorStrategy = $strategy;
        return $this;
    }

    /**
     * Disable uniqueness check for generated slugs.
     *
     * @return $this
     */
    public function disableSlugUniqueness(): self
    {
        $this->unique = false;
        return $this;
    }
    

    /**
     * Get the custom callable function used for generating the slug.
     *
     * @return bool 6
     */
    public function iSlugOnEmpty(): bool
    {
        return $this->generateSlugOnEmpty;
    }

    /**
     * Get the custom callable function used for generating the slug.
     *
     * @return callable|null The callable function used for generating the slug, or null if not set.
     */
    public function getSlugUsing(): ?callable
    {
        return $this->slugUsing;
    }

    /**
     * Get the prefix that will be added to the generated slug.
     *
     * @return string The prefix for the slug.
     */
    public function getSlugWithPrefix(): string
    {
        return $this->slugWithPrefix;
    }

    /**
     * Get the prefix that will be added to the generated slug.
     *
     * @return string The prefix for the slug.
     */
    public function getUniqueSuffixSeparator(): string
    {
        return $this->uniqueSuffixSeparator;
    }

    /**
     * Get the suffix that will be added to the generated slug.
     *
     * @return string The suffix for the slug.
     */
    public function getSlugWithSuffix(): string
    {
        return $this->slugWithSuffix;
    }

    /**
     * Set the prefix that should be added to the generated slug.
     *
     * @param string $prefix The prefix to be added to the slug.
     * @return $this
     */
    public function withPrefix(string $prefix): self
    {
        $this->slugWithPrefix = $prefix;
        return $this;
    }

    /**
     * Set the suffix that should be added to the generated slug.
     *
     * @param string $suffix The suffix to be added to the slug.
     * @return $this
     */
    public function withSuffix(string $suffix): self
    {
        $this->slugWithSuffix = $suffix;
        return $this;
    }

    /**
     * Generate a unique slug based on the provided source attributes.
     *
     * @param array $sourceAttributes
     * @return string
     */
    public function generateUniqueSlug(array $sourceAttributes, Model $model): string
    {

        $slug = $this->slugColumnsMapping->generateSlug($sourceAttributes);

        if ($this->isUnique()) {
            $slug = $this->generateUniqueSlugWithSuffix($slug, $model);
        }

        return $slug;
    }

    /**
     * Custom function to generate a unique slug with a fallback suffix (e.g., -1, -2, etc.)
     *
     * @param string   $baseSlug  The base slug without the suffix.
     * @param int      $suffix    The current suffix number to be added to the slug.
     * @return string             The unique slug with the suffix.
     */
    public function generateUniqueSlugWithSuffix(string $baseSlug, Model $model, int $suffix = 0): string
    {
        if ($suffix > 0) {
            $slugWithSuffix = $baseSlug . $this->separator . $suffix;
        } else {
            $slugWithSuffix = $baseSlug;
        }

        // Check if the slug with suffix is already reserved or exists in the database
        if ($this->isSlugReserved($slugWithSuffix) || $this->isSlugExistsInDatabase($slugWithSuffix, $model)) {
            if ($suffix >= $this->maxAttempts) {
                throw new \RuntimeException("Maximum number of attempts reached to generate a unique slug.");
            }
            return $this->generateUniqueSlugWithSuffix($baseSlug, $model, $suffix + 1);
        }

        return $slugWithSuffix;
    }

    /**
     * Check if the given slug is reserved (e.g., restricted keywords).
     * Return true if the slug is reserved, otherwise return false.
     *
     * @param string $slug The slug to be checked.
     * @return bool
     */
    public function isSlugReserved(string $slug): bool
    {
        // Implement logic to check if the given slug is reserved (e.g., restricted keywords).
        // For example, check against a predefined list of reserved slugs or patterns.
        // Return true if the slug is reserved, otherwise return false.
        return in_array($slug, $this->reservedWords);
    }

    public function isUnique(): bool
    {
        return $this->unique;
    }

    /**
     * Check if the given slug already exists in the database.
     * Return true if the slug exists, otherwise return false.
     *
     * @param string $slug The slug to be checked.
     * @return bool
     */
    public function isSlugExistsInDatabase(string $slug, Model $model): bool
    {
        $slugAttribute = $this->getSlugOptions()->getSlugAttribute();
        return $model->where($slugAttribute, $slug)
            ->where('id', '<>', $model->getKey())
            ->exists();
    }

    /**
     * Set the option to use lowercase letters only in the generated slug.
     *
     * @return $this
     */
    public function useLowercaseOnly(): self
    {
        $this->slugWithLowercase = true;
        return $this;
    }

    /**
     * Set the option to use alphanumeric characters only in the generated slug.
     *
     * @return $this
     */
    public function useAlphanumericOnly(): self
    {
        $this->slugWithNumbers = true;
        return $this;
    }

    /**
     * Set the option to use alphanumeric characters with underscores in the generated slug.
     *
     * @return $this
     */
    public function useAlphanumericWithUnderscore(): self
    {
        $this->slugWithNumbers = true;
        $this->slugWithUnderscore = true;
        return $this;
    }

    public function getSlugAttribute(): string
    {
        return $this->slugAttribute;
    }

    public function getReservedWords(): array
    {
        return $this->reservedWords;
    }

    public function setSlugAttribute(string $slugAttribute): void
    {
        $this->slugAttribute = $slugAttribute;
    }

    /**
     * Get the attribute where the generated slug will be saved.
     *
     * @param  string $attribute
     * @return string
     */
    public function getSaveTo(): string
    {
        return $this->slugAttribute;
    }

    // Getter and Setter for $source
    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source): void
    {
        $this->source = $source;
    }

    // Getter and Setter for $separator
    public function getSeparator(): string
    {
        return $this->separator;
    }

    public function setSeparator(string $separator): void
    {
        $this->separator = $separator;
    }

    // Getter and Setter for $language
    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    // Getter and Setter for $onUpdate
    public function getOnUpdate(): bool
    {
        return $this->onUpdate;
    }

    public function setOnUpdate(bool $onUpdate): void
    {
        $this->onUpdate = $onUpdate;
    }

    // Getter and Setter for $maxLength
    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }

    // Getter and Setter for $maxAttempts
    public function getMaxAttempts(): ?int
    {
        return $this->maxAttempts;
    }

    public function setMaxLength(?int $maxLength): void
    {
        $this->maxLength = $maxLength;
    }

}
