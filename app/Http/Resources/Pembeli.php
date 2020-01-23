<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Pembeli extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'alamat' => $this->alamat,
            // 'harga' => $this->harga,
            // 'stok' => $this->stok,
            // 'deskripsi' => $this->deskripsi,
            // 'foto' => base64_encode($disk->get($this->foto))
            'foto_ktp' => $this->foto_ktp !== null ? (base64_encode($disk->get($this->foto_ktp))) :  '',

        ];
    }
}
