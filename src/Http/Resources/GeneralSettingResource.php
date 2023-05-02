<?php

namespace Josefo727\GeneralSettings\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GeneralSettingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->valueForDisplay,
            'description' => $this->description,
            'type' => $this->type,
        ];
    }
}
