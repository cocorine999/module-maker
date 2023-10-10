<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs;

use App\Models\User;
use LaravelCoreModule\CoreModuleMaker\Exceptions\QueryException as CoreQueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;


/**
 * #### Trait HasCreator
 *
 * The HasCreator trait provides functionality related to the creator of a model.
 *
 * #### Usage:
 * - This trait should be used in models that have a "creator" association.
 *
 * #### Methods:
 * - bootHasCreator(): This method is called when the trait is booted. It sets the default creator for the model to
 *   the currently authenticated user if it is not already set.
 *
 * - creator(): This method defines a relationship to the creator of the model. It returns a BelongsTo instance
 *   representing the association.
 *
 * - createdBy($user): This method checks if the model was created by the given user. It accepts a User instance or
 *   user ID as the parameter and returns true if the model was created by the user, and false otherwise.
 *
 * - scopeCreatedBy($query, $user): This method is a query scope that filters the query to only include models created
 *   by the given user. It accepts a User instance or user ID as the parameter and modifies the query accordingly.
 *
 *
 * #### Usages:
 * 1. Use the trait in your model class:
 *    ```
 *    use Illuminate\Database\Eloquent\Model;
 *    use LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs;
 *
 *    class YourModel extends Model {
 *      use HasCreator;
 *        // Model implementation
 *    }
 *    ```
 * 2. Retrieve the creator of a model:
 *    ```
 *    $model = YourModel::find(1);
 *    $creator = $model->creator;
 *    ```
 * 3. Check if a model was created by a specific user:
 *    ```
 *    $user = User::find(1);
 *    $isCreatedByUser = $model->createdBy($user);
 *    ```
 * 4. Query models created by a specific user:
 *    ```
 *    $user = User::find(1);
 *    $models = YourModel::createdBy($user)->get();
 *    ```
 *
 * Example Usage:
 * Assuming you have a `Post` model that uses the `HasCreator` trait, you can use the trait's functionality as follows:
 *
 * ```php
 * use Illuminate\Database\Eloquent\Model;
 * use LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs;
 *
 * class Post extends Model
 * {
 *     use HasCreator;
 *
 *     // Model implementation
 * }
 *
 * // Retrieving the creator of a post
 * $post = Post::find(1);
 * $creator = $post->creator;
 *
 * // Checking if a post was created by a specific user
 * $user = User::find(1);
 * $isCreatedByUser = $post->createdBy($user);
 *
 * // Querying posts created by a specific user
 * $user = User::find(1);
 * $posts = Post::createdBy($user)->get();
 * ```
 * @package LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs
 */
trait HasCreator
{

    /**
     * Get the user who created the model.
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Set the creator of the model.
     *
     * @param User|null $user
     * @return void
     */
    public function setCreator(?User $user): void
    {
        if ($user)
            $this->creator()->associate($user);
            ///throw new ModelNotFoundException("User not found.");

        ///$this->creator()->associate($user);
    }


    /**
     * Get the creator associated with the model.
     *
     * @return User|null
     */
    public function getCreator(): ?User
    {
        return $this->creator;
    }

    /**
     * Check if the model has a creator associated with it.
     *
     * @return bool
     */
    public function hasCreator(): bool
    {
        return $this->creator !== null;
    }

    /**
     * Get the creator's name.
     *
     * @return string|null
     */
    public function getCreatorName(): ?string
    {
        return $this->creator ? $this->creator->full_name : null;
    }

    /**
     * Scope the query to only include models created by the specified utilisateur.
     *
     * @param  Builder $query
     * @param  User|string $user
     * @return Builder
     */
    public function scopeCreatedBy(Builder $query, $user): Builder
    {
        try {

            if ($user instanceof User) {
            } elseif (Str::isUuid($user)) {
                $user = User::where('id', $user)->firstOrFail();
            } else {
                $user = User::where('full_name', $user)->firstOrFail();
            }

            return $query->where('created_by', $user->id);
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: $exception->getMessage(), code: $exception->getCode());
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('User not found.');
        }
    }

    /**
     * Boot the trait.
     *
     * @return void
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\QueryException
     */
    public static function bootHasCreator(): void
    {
        static::creating(function ($model) {

            $user = null;
            
            // Set the default creator if not already set
            if (!$model->created_by) {
                if (auth()->check()) {
                    $model->setCreator(auth()->user());
                }
                else {
                    try {
                        
                        /* $user = User::whereHas('roles', function ($query) {
                            // For example, check for a specific role name
                            $query->where('slug', 'admin');
                        })->orWhereHas('rolesThroughProfiles', function ($query) {
                            // For example, check for a specific role name
                            $query->where('slug', 'admin');
                        })->where("status", TRUE)->first(); ///->firstOrFail();  */

                        $model->setCreator($user);
                    } catch (QueryException $exception) {
                        ///throw $exception;
                        ///throw new CoreQueryException(message: $exception->getMessage(), code: $exception->getCode());
                        // Handle any query exceptions that may occur
                        // You can customize the error handling here
                    } catch (ModelNotFoundException $exception) {
                        throw new ModelNotFoundException('User not found.');
                    }
                }
            }
        });
    }
    
}