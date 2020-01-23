<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Produk as ProdukResource;
use App\Http\Resources\Pembeli as PembeliResource;



class PembelianBarang extends JsonResource
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
        return [
            'id' => $this->id,
            'jumlah' => $this->jumlah,
            'total' => $this->total,
            'alamat_pengiriman' => $this->alamat_pengiriman,
            'nomor_rekening' => $this->nomor_rekening,
            'nama_rekening' => $this->nama_rekening,
            'nomor_resi' => $this->nomor_resi !== null ? $this->nomor_resi : '',
            'status' => $this->status,
            'foto_pembayaran' => $this->foto_pembayaran !== null ? (base64_encode($disk->get($this->foto_pembayaran))) :  '',
            'produk' => new ProdukResource($this->whenLoaded('produk')),
            'pembeli' => new PembeliResource($this->whenLoaded('pembeli'))
        ];
    }
}