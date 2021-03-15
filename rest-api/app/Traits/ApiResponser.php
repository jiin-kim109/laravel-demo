<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }

        $transformer = $collection->first()->transformer;
        $collection = $this->filterData($collection);
        $collection = $this->sortData($collection);
        $collection = $this->paginate($collection);
        $collection = $this->transformData($collection, $transformer);
        $collection = $this->cacheResponse($collection);

        return $this->successResponse($collection, $code);
    }

    protected function showOne(Model $model, $code = 200)
    {
        $transformer = $model->transformer;
        $model = $this->transformData($model, $transformer);

        return $this->successResponse($model, $code);
    }

    protected function sortData(Collection $collection)
    {
        if (request()->has('sort_by')) {
            $attribute = request()->sort_by;

            $collection = $collection->sortBy($attribute);
        }

        return $collection;
    }

    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }

    protected function filterData(Collection $collection)
    {
        foreach (request()->query() as $query => $value) {
            if (isset($collection->first()[$query]) && isset($value)) {
                $collection = $collection->where($query, $value);
            }
        }

        return $collection;
    }

    protected function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50'
        ];

        Validator::validate(request()->all(), $rules);

        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = request()->has('per_page') ? (int) request()->per_page : 15;

        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPage()
        ]);

        $paginated->appends(request()->all());

        return $paginated;
    }

    protected function cacheResponse($data)
    {
        $url = request()->url();
        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30, function () use ($data) {
            return $data;
        });
    }
}
