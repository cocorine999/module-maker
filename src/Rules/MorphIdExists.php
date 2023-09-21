<?php

declare(strict_types = 1);

namespace LaravelCoreModule\CoreModuleMaker\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

/**
 * Class `MorphIdExists`
 *
 * The MorphIdExists rule checks if a given value exists for the authenticated user and is a valid UUID.
 *
 * @package \LaravelCoreModule\CoreModuleMaker\Rules
 */
class MorphIdExists implements Rule
{
    protected $table;
    protected $attribute;
    protected $column;

    public function __construct(string $table = null, string $column = 'id')
    {
        $this->table = $table;
        $this->column = $column;
    }
    
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute The attribute being validated.
     * @param  mixed   $value     The value being validated.
     * @return bool               True if the validation passes, false otherwise.
     */
    public function passes($attribute, $value)
    {

        $this->attribute = $attribute;

        // Extract the morph type from the attribute name
        $morphTypeColumn = convert_to_snake_case(str_replace('_id', '', $attribute)) . '_type';

        // Get the input data for "morph type" value
        $morphType = request()->input($morphTypeColumn);

        if(!$this->table)
        {
            if(!($model = loadModel($value))) return false;
            $this->table = $model->getTable();
        }
        
        // Query the database to check if the combination exists
        return DB::table($this->table)
                    ->where($this->column, $value)
                    ->where($morphTypeColumn, $morphType)
                    ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string The validation error message.
     */
    public function message()
    {
        return 'The selected ' . str_replace('_', ' ', $this->attribute) . ' does not exist for the given morph type.';
    }

}
