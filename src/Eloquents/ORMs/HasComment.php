<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs;

use Illuminate\Database\Eloquent\Builder;


/**
 * #### Trait HasComment
 *
 * The HasComment trait provides functionality related to comments for a model.
 *
 * #### Usage:
 * - This trait should be used in models that have a "comments" association.
 *
 * #### Methods:
 * - bootHasComment(): This method is called when the trait is booted. It sets up default comment-related behaviors.
 *
 * - comments(): This method defines a relationship to the comments of the model. It returns a HasMany instance
 *   representing the association.
 *
 * - addComment($commentData): This method allows adding a comment to the model. It accepts an array of comment data
 *   and returns the created comment instance.
 *
 * - deleteComment($comment): This method allows deleting a comment associated with the model.
 *
 * - scopeWithComments($query): This method is a query scope that includes comments when retrieving models.
 *
 * #### Usages:
 * 1. Use the trait in your model class:
 *    ```
 *    use Illuminate\Database\Eloquent\Model;
 *    use LaravelCoreModule\CoreModuleMaker\Eloquents\Traits\HasComment;
 *
 *    class YourModel extends Model {
 *      use HasComment;
 *        // Model implementation
 *    }
 *    ```
 * 2. Retrieve comments for a model:
 *    ```
 *    $model = YourModel::find(1);
 *    $comments = $model->comments;
 *    ```
 * 3. Add a comment to a model:
 *    ```
 *    $commentData = ['text' => 'This is a comment', 'user_id' => 1];
 *    $comment = $model->addComment($commentData);
 *    ```
 * 4. Delete a comment associated with a model:
 *    ```
 *    $comment = Comment::find(1); // Assuming you have a Comment model
 *    $model->deleteComment($comment);
 *    ```
 *
 * Example Usage:
 * Assuming you have a `Post` model that uses the `HasComment` trait, you can use the trait's functionality as follows:
 *
 * ```php
 * use Illuminate\Database\Eloquent\Model;
 * use LaravelCoreModule\CoreModuleMaker\Eloquents\Traits\HasComment;
 *
 * class Post extends Model
 * {
 *     use HasComment;
 *
 *     // Model implementation
 * }
 *
 * // Retrieving comments for a post
 * $post = Post::find(1);
 * $comments = $post->comments;
 *
 * // Adding a comment to a post
 * $commentData = ['text' => 'This is a comment', 'user_id' => 1];
 * $comment = $post->addComment($commentData);
 *
 * // Deleting a comment associated with a post
 * $comment = Comment::find(1); // Assuming you have a Comment model
 * $post->deleteComment($comment);
 * ```
 * @package LaravelCoreModule\CoreModuleMaker\Eloquents\Traits
 */
trait HasComment
{
    /**
     * Get the comments associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(\App\Models\Comment::class, 'commentable');
    }

    /**
     * Add a new comment to the model.
     *
     * @param string $comment
     * @param string|null $commentId
     * @param bool $status
     * @param bool $canBeDelete
     * @param string|null $createdBy
     * @return \App\Models\Comment
     */
    public function addComment(
        string $comment,
        ?string $commentId = null
    ): \App\Models\Comment {
        return $this->comments()->create([
            'comment' => $comment,
            'comment_id' => $commentId
        ]);
    }

    /**
     * Remove a comment from the model.
     *
     * @param string $commentId
     * @return bool|null
     */
    public function removeComment(string $commentId): ?bool
    {
        $comment = $this->comments()->findOrFail($commentId);

        if ($comment) {
            return $comment->delete();
        }

        return null;
    }

    /**
     * Update a comment for the model.
     *
     * @param string $commentId
     * @param string $newComment
     * @return bool|null
     */
    public function updateComment(string $commentId, string $newComment): ?bool
    {
        $comment = $this->comments()->findOrFail($commentId);

        if ($comment) {
            $comment->comment = $newComment;
            return $comment->save();
        }

        return null;
    }

    /**
     * Get the count of comments for the model.
     *
     * @return int
     */
    public function getCommentCount(): int
    {
        return $this->comments()->count();
    }

    /**
     * Scope the query to include comments when retrieving models.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithComments(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->with('comments');
    }

    /**
     * Boot the trait.
     *
     * @return void
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\QueryException
     */
    /* public static function bootHasComment(): void
    {    
        // Additional scope to retrieve models with more than 3 comments
        static::addGlobalScope('hasMoreThanThreeComments', function (Builder $builder) {
            $builder->has('comments', '>', 3);
        });

        // Set default sorting order for comments
        static::addGlobalScope('orderByLatestComments', function (Builder $builder) {
            $builder->with(['comments' => function ($query) {
                $query->latest();
            }]);
        });

        static::creating(function ($model) {
            if (! $model->isValidComment()) {
                throw new \Exception('Invalid comment data.');
            }
        });
    } */

    public function isValidComment(): bool
    {
        // Implement your custom validation logic here
        return true; // or false based on your criteria
    }
}
