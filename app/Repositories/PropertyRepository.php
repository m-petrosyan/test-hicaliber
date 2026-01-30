<?php

namespace App\Repositories;

use App\Models\Property;
use Illuminate\Support\Collection;

class PropertyRepository
{
    /**
     *
     * @param  array  $criteria
     * @return Collection
     */
    public function search(array $criteria): Collection
    {
        $query = Property::query()
            ->when(!empty($criteria['name'] ?? null), fn($q) => $q->where('name', 'like', '%'.$criteria['name'].'%')
            )
            ->when(isset($criteria['bedrooms']), fn($q) => $q->where('bedrooms', $criteria['bedrooms'])
            )
            ->when(isset($criteria['bathrooms']), fn($q) => $q->where('bathrooms', $criteria['bathrooms'])
            )
            ->when(isset($criteria['storeys']), fn($q) => $q->where('storeys', $criteria['storeys'])
            )
            ->when(isset($criteria['garages']), fn($q) => $q->where('garages', $criteria['garages'])
            )
            ->when(isset($criteria['price_min']), fn($q) => $q->where('price', '>=', $criteria['price_min'])
            )
            ->when(isset($criteria['price_max']), fn($q) => $q->where('price', '<=', $criteria['price_max'])
            );

        return $query->get();
    }
}
