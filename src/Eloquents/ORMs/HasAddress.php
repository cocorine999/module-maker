<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs;

use LaravelCoreModule\CoreModuleMaker\Exceptions\QueryException as CoreQueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

/**
 * #### Trait HasAddress
 *
 * The HasAddress trait provides functionality related to addresses for a model.
 *
 * #### Usage:
 * - This trait should be used in models that have an "address" association.
 *
 * #### Methods:
 * - bootHasAddress(): This method is called when the trait is booted. It sets up default address-related behaviors.
 *
 * - address(): This method defines a relationship to the address of the model. It returns a MorphOne instance
 *   representing the association.
 *
 * - setAddress($addressData): This method allows setting or updating the address for the model. It accepts an array of
 *   address data and returns the updated address instance.
 *
 * - getAddress(): This method retrieves the associated address for the model.
 *
 * #### Usages:
 * 1. Use the trait in your model class:
 *    ```
 *    use Illuminate\Database\Eloquent\Model;
 *    use LaravelCoreModule\CoreModuleMaker\Eloquents\Traits\HasAddress;
 *
 *    class YourModel extends Model {
 *      use HasAddress;
 *        // Model implementation
 *    }
 *    ```
 * 2. Retrieve the address for a model:
 *    ```
 *    $model = YourModel::find(1);
 *    $address = $model->getAddress();
 *    ```
 * 3. Set or update the address for a model:
 *    ```
 *    $addressData = ['street' => '123 Main St', 'city' => 'Example City', 'state' => 'CA', 'zip_code' => '12345'];
 *    $model->setAddress($addressData);
 *    ```
 *
 * Example Usage:
 * Assuming you have a `User` model that uses the `HasAddress` trait, you can use the trait's functionality as follows:
 *
 * ```php
 * use Illuminate\Database\Eloquent\Model;
 * use LaravelCoreModule\CoreModuleMaker\Eloquents\Traits\HasAddress;
 *
 * class User extends Model
 * {
 *     use HasAddress;
 *
 *     // Model implementation
 * }
 *
 * // Retrieving the address for a user
 * $user = User::find(1);
 * $address = $user->getAddress();
 *
 * // Setting or updating the address for a user
 * $addressData = ['street' => '123 New Ave', 'city' => 'New City', 'state' => 'NY', 'zip_code' => '54321'];
 * $user->setAddress($addressData);
 * ```
 * @package LaravelCoreModule\CoreModuleMaker\Eloquents\Traits
 */
trait HasAddress
{
    /**
     * Define a morph one relationship for the address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function address(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * Get the addresses associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Set an address for the model.
     *
     * @param array $addressData
     * @return void
     */
    public function newAddress(array $addressData): void
    {
        $address = $this->address ?: new \App\Models\Address();
        $address->fill($addressData);
        $this->address()->save($address);
    }

    /**
     * Update the address associated with the model.
     *
     * @param array $addressData
     * @return void
     */
    public function updateAddress(array $addressData): void
    {
        $address = $this->address ?: new \App\Models\Address();
        $address->fill($addressData);
        $this->address()->save($address);
    }

    /**
     * Remove the address associated with the model.
     *
     * @return void
     */
    public function removeAddress(): void
    {
        if ($this->address) {
            $this->address->delete();
        }
    }

    /**
     * Set or update the address for the model.
     *
     * @param array $addressData
     * @return \App\Models\Address
     */
    public function setAddress(array $addressData): \App\Models\Address
    {
        if ($this->address) {
            // If the model already has an address, update it
            $this->address->update($addressData);
        } else {
            // If no address exists, create a new one
            $this->address()->create($addressData);
        }

        return $this->getAddress();
    }

    /**
     * Add an address to the model.
     *
     * @param array $addressData
     * @return \App\Models\Address
     */
    public function addAddress(array $addressData): \App\Models\Address
    {
        return $this->addresses()->create($addressData);
    }

    /**
     * Delete an address associated with the model.
     *
     * @param \App\Models\Address $address
     * @return void
     */
    public function deleteAddress(\App\Models\Address $address): void
    {
        $address->delete();
    }

    /**
     * Get the associated address for the model.
     *
     * @return \App\Models\Address|null
     */
    public function getAddress(): ?\App\Models\Address
    {
        return $this->address;
    }

    /**
     * Scope the query to include addresses when retrieving models.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithAddresses(Builder $query): Builder
    {
        return $query->with('addresses');
    }

    /**
     * Boot the trait.
     *
     * @return void
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\QueryException
     */
    public static function bootHasAddress(): void
    {
        static::creating(function ($model) {
            // You can add custom logic here before creating the model
        });
    }
}