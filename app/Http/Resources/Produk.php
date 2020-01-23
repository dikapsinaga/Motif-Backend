<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Pelapak as PelapakResource;


class Produk extends JsonResource
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
        $disk = \Storage::disk('gcs');
        // // dd($disk->get($url_ktp));

        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'nama' => $this->nama,
            'jenis' => $this->jenis,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'deskripsi' => $this->deskripsi,
            'pelapak' => new Pelapak($this->whenLoaded('pelapak')),
            'foto' => base64_encode($disk->get($this->foto))
        ];

    }
}
