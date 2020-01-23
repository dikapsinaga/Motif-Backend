<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Pelapak extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $disk = \Storage::disk('gcs');
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'alamat' => $this->alamat,
            // 'harga' => $this->harga,
            // 'stok' => $this->stok,
            // 'deskripsi' => $this->deskripsi,
            'foto_lapak' => $this->foto_lapak !== null ? (base64_encode($disk->get($this->foto_lapak))) :  '',
            // 'foto' => this base64_encode($disk->get($this->foto))
        ];
    }
}
