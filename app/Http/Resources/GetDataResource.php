<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetDataResource extends JsonResource
{
  public $preserveKeys = true;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    // public function toArray($request)
    // {
    //   return [
    //     'username' => $this->username,
    //     'fullname' => $this->fullname,
    //     'grade' => $this->grade
    //     // 'data' => $this->collection
    //   ];
    // }
}
