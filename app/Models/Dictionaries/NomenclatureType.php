<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class NomenclatureType extends AbstractDictionary implements NomenclatureTypeInterface
{
    protected $fillable = [
        'name',
    ];

    public static function rules(): array
    {
        return [
            'name' => 'string|required',
        ];
    }

    public function nomenclatures():HasMany
    {
        return $this->hasMany(Nomenclature::class);
    }

    public function tryToDelete():bool
    {
        $nomenclatures = $this->nomenclatures();
        if ($nomenclatures->count() > 0) return false;

        try {
            $this->delete();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
