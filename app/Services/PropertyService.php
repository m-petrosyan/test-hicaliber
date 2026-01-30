<?php

namespace App\Services;

use App\Repositories\PropertyRepository;
use Illuminate\Support\Collection;

class PropertyService
{
    public function __construct(
        protected PropertyRepository $repository
    ) {
    }

    /**
     *
     * @param  array  $criteria
     * @return Collection
     */
    public function searchProperties(array $criteria): Collection
    {
        return $this->repository->search($criteria);
    }
}
