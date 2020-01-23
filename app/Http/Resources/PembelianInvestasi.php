<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Plan as PlanResource;
use App\Http\Resources\Pembeli as PembeliResource;



class PembelianInvestasi extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'nominal' => $this->nominal,
            'nomor_rekening' => $this->nomor_rekening,
            'nama_rekening' => $this->nama_rekening,
            'status' => $this->status,
            'plan' => new PlanResource($this->whenLoaded('plan')),
            'pembeli' => new PembeliResource($this->whenLoaded('pembeli'))
        ];
    }
}
