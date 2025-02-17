<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ServiceResponse
{
    private $data;
    private $status;
    private static array $resourceMap = [
    ];

    public function __construct($data, int $status = 200)
    {
        $this->data = $data;
        $this->status = $status;
    }

    public function toResponse()
    {
        $transformedData = $this->transformData($this->data);
        return response()->json($transformedData, $this->status);
    }

    private function transformData($data)
    {
        if (is_null($data)) {
            return null;
        }

        if (is_array($data)) {
            return $this->transformArrayData($data);
        }

        if ($data instanceof Collection || $data instanceof Model) {
            return $this->transformModelData($data);
        }

        return $data;
    }

    private function transformArrayData(array $data): array
    {
        $result = [];
        
        foreach ($data as $key => $value) {
            if (is_null($value)) {
                $result[$key] = null;
                continue;
            }

            if ($resourceClass = $this->getResourceClassForKey($key)) {
                if (is_array($value) && isset($value[0])) {
                    // Koleksiyon için
                    $result[$key] = $resourceClass::collection($value);
                } else {
                    // Tekil kayıt için
                    $result[$key] = new $resourceClass($value);
                }
            } else if (is_array($value)) {
                // İç içe array'ler için recursive dönüşüm
                $result[$key] = $this->transformArrayData($value);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    private function transformModelData($data)
    {
        if (is_null($data)) {
            return null;
        }

        $modelName = Str::snake(class_basename($data));
        if ($resourceClass = $this->getResourceClassForKey($modelName)) {
            if ($data instanceof Collection) {
                return $resourceClass::collection($data);
            }
            return new $resourceClass($data);
        }
        return $data;
    }

    private function getResourceClassForKey(string $key): ?string
    {
        $singularKey = Str::singular($key);
        $pluralKey = Str::plural($key);

        return static::$resourceMap[$key] 
            ?? static::$resourceMap[$singularKey] 
            ?? static::$resourceMap[$pluralKey] 
            ?? null;
    }

    public static function registerResourceMap(array $map): void
    {
        static::$resourceMap = array_merge(static::$resourceMap, $map);
    }
}
