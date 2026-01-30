<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertySearchRequest;
use App\Http\Resources\PropertyResource;
use App\Services\PropertyService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PropertyController extends Controller
{
    public function __construct(
        protected PropertyService $service
    ) {}

    /**
     * Handle property search request.
     *
     * @param PropertySearchRequest $request
     * @return AnonymousResourceCollection
     */
    public function search(PropertySearchRequest $request): AnonymousResourceCollection
    {
        $results = $this->service->searchProperties($request->validated());

        return PropertyResource::collection($results);
    }
}
