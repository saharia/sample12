<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Router extends Model
{
  use SoftDeletes;
    //
    protected $fillable = [
      'sap_id',
      'host_name',
      'loop_back',
      'mac_address'
    ];
    private $rules = [
      'sap_id' => 'required|unique:routers|max:18|regex:/[0-9A-Za-z]/',
      'host_name' => 'required|unique:routers|max:14|regex:/[0-9A-Za-z]/',
      'loop_back' => 'required|unique:routers|max:45|ipv4',
      'mac_address' => [
        'required', 
        'unique:routers',
        'max:17',
        'regex:/^(([a-fA-F0-9]{2}-){5}[a-fA-F0-9]{2}|([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}|([0-9A-Fa-f]{4}\.){2}[0-9A-Fa-f]{4})?$/'
        ]
      ];

    public function insertData($data) {
      $validator = \Validator::make($data, $this->rules);
      if ($validator->fails()) {
        return $validator->messages();
      } else {
        self::create($data);
      }
    }
}
