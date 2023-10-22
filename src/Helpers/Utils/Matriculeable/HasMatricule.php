<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Matriculeable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


/**
 * Trait HasMatricule
 *
 * The `HasMatricule` trait automatically generates unique matricule numbers for model instances.
 *
 * @package LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Matriculeable
 */
trait HasMatricule
{
    /**
     * Boot the HasMatricule trait for the model.
     *
     * @return void
     */
    public static function bootHasMatricule(): void
    {
        static::creating(function (Model $model) {
            
            if ($model->hasMatriculeAttribute() && $model->shouldGenerateMatricule()) {
                $model->generateMatricule($model);
            }
        });
    }

    private function generateMatricule(Model $model)
    {
        $matricule = $this->generateResourceMatricule($model);

        // Check uniqueness in the database
        while (self::matriculeExists( $model->getTable(), $model->getMatriculeColumn(), $matricule)) {

            $count = strtoupper(Str::random(3));
            $matricule = '-' . $count;
        }

        $model->{$model->getMatriculeColumn()} = $matricule;
    }

    
    /**
     * Get the column name used for the matricule.
     *
     * @return string
     */
    public function getMatriculeColumn()
    {
        return 'matricule'; // Customize this if the column name is different
    }


    abstract protected function hasMatriculeAttribute();

    public function shouldGenerateMatricule()
    {
        if($this->hasMatriculeAttribute())
        {
            return true;
        }
    }

    private function generateResourceMatricule(Model $model)
    {
        switch ($model->getTable()) {
            case 'leads':
                return $this->generateUserMatricule($model);
                break;

            case 'clients':
                return $this->generateUserMatricule($model);
                break;

            case 'tenants':
                return $this->generateUserMatricule($model);
                break;

            case 'owners':
                return $this->generateUserMatricule($model);
                break;
            
            default:
                return $this->generateUserMatricule($model);
                break;
        }
    }

    private function generateUserMatricule(Model $model)
    {
        $matricule = $this->getResourceIdentifier($model->getTable());
        $matricule .= "-" . strtoupper($this->generateUniqueNumber());
        $matricule .= "-" . $this->getSexIdentifier($model->sex->value);
        $matricule .= /* "-" .  */$this->getAccountTypeIdentifier($model->type_of_account->value);
        $matricule .= "-" . $this->generateNDigitRandomNumber(6);

        return $matricule;
    }



    public function generateNDigitRandomNumber($length){
        return mt_rand(pow(10,($length-1)),pow(10,$length)-1);
    }

    private function getResourceIdentifier(string $resource = 'users')
    {
        $resources = [
            'leads' => [
                'key'   => 'LD',
                'level' => 0,
                'code'  => '0-005'
            ],

            'clients' => [
                'key'  => 'CLT',
                'level' => 1,
                'code' => '1-006'
            ],

            'tenants' => [
                'key'  => 'TNT',
                'level' => 2,
                'code' => '2-007'
            ],

            'owners' => [
                'key'  => 'OWN',
                'level' => 3,
                'code' => '3-006'
            ],

            'asset_managers' => [
                'key'  => 'AM',
                'level' => 4,
                'code' => '3-006'
            ],

            'managers' => [
                'key'  => 'MGR',
                'level' => 5,
                'code' => '5-006'
            ],

            'administrators' => [
                'key'  => 'ADM',
                'level' => 6,
                'code' => '6-006'
            ],

            'super_administrators' => [
                'key'  => 'SA',
                'level' => 7,
                'code' => '7-015'
            ],

            'users' => [
                'key'  => 'USR',
                'code' => '7-015'
            ]
        ];

        return $resources[$resource]['key'];
    }

    private function getSexIdentifier($sex)
    {
        // Define a mapping of sex values to identifiers
        $sexIdentifiers = [
            'male' => 'M',
            'female' => 'F',
            'other' => 'O',
        ];
    
        // Check if the provided sex exists in the mapping, or use a default identifier
        return $sexIdentifiers[$sex] ?? 'U'; // 'U' for unknown or default
    }

    private function getAccountTypeIdentifier($accountType)
    {
        // Define a mapping of account type values to identifiers
        $accountTypeIdentifiers = [
            'personal' => 'P',
            'enterprise' => 'E',
        ];
    
        // Check if the provided account type exists in the mapping, or use a default identifier
        return $accountTypeIdentifiers[$accountType] ?? 'U'; // 'U' for unknown or default
    }

    private function generateUniqueNumber()
    {
        return Str::random(6); // Generate a unique random string
    }

    /**
     * Check if a matricule already exists in the specified table and column.
     *
     * @param  string  $table  The table name.
     * @param  string  $columnName  The column name.
     * @param  string  $value  The value of the matricule.
     * @return bool  True if the matricule exists, false otherwise.
     */
    protected function matriculeExists(string $table = 'users', string $columnName = 'matricule', string $value): bool
    {
        return DB::table($table)->where($columnName, $value)->exists();
    }

}