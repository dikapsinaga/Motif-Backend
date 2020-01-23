<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Pelapak as PelapakResource;
use App\PembelianInvestasi;


class Plan extends JsonResource
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
        $jumlah_donatur = PembelianInvestasi::where('plan_id', $this->id)->get();
        
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'profit' => $this->profit,
            'dana_dibutuhkan' => $this->dana_dibutuhkan,
            'dana_terkumpul' => $this->dana_terkumpul,
            'days' => $this->days,
            'return_days' => $this->return_days,
            'start_date' => $this->start_date,
            'status' => $this->status,
            'nomor_rekening' => $this->nomor_rekening,
            'nama_rekening' => $this->nama_rekening,
            'jumlah_donatur' => $jumlah_donatur->count(),
            'foto' => base64_encode($disk->get($this->foto)),
            'pelapak' => new PelapakResource($this->whenLoaded('pelapak'))
        ];
    }
}
