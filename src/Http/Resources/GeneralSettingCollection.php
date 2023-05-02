<?php

namespace Josefo727\GeneralSettings\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GeneralSettingCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            /* 'data' => GeneralSettingResource::collection($this->collection), */
        ];
    }
}
