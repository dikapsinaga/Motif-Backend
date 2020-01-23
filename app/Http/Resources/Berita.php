<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class Berita extends JsonResource
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
        // return parent::toArray($request);
        return [
            'judul' => $this->judul,
            'berita' => $this->berita,
            
            'tanggal' => Carbon::parse($this->created_at)->isoFormat('D/M/YYYY'),
            'foto' =>  base64_encode($disk->get($this->foto)),
        ];

    }
}
