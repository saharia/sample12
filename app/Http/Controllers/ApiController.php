<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Router;
class ApiController extends Controller
{
    //

    public function index() {
      $routers = Router::orderby('id', 'desc')->get();
      return response()->json([ 'routers' => $routers ]);
    }

    public function getByIpRange() {
      $routers = Router::orderby('id', 'desc')->get();
      return response()->json([ 'routers' => $routers ]);
    }

    public function getBySapId(Request $request) {
      $sap_id = $request->sap_id;
      $routers = Router::orderby('id', 'desc')->where('sap_id', $sap_id)->first();
      return response()->json([ 'router' => $routers ]);
    }

    public function deleteByIp(Request $request) {
      $ip = $request->loop_back;
      $data = Router::where('loop_back', $ip)->first();
      if($data) {
        $data->delete();
        return response()->json([ 'msg' => 'record removed successfully' ]);
      } else {
        return response()->json([ 'msg' => 'Record not found' ], 404);
      }
    }

    public function updateByIp(Request $request) {
      $ip = $request->loop_back;
      $data = Router::where('loop_back', $ip)->first();
      if($data) {
        $id = $data->id;
        $request->validate([
          'sap_id' => 'required|unique:routers,sap_id,'.$id.'|max:18|regex:/[0-9A-Za-z]/',
          'host_name' => 'required|unique:routers,host_name,'.$id.'|max:14|regex:/[0-9A-Za-z]/',
          'loop_back' => 'required|unique:routers,loop_back,'.$id.'|max:45|ipv4',
          'mac_address' => 
          [
            'required', 
            'unique:routers,mac_address,'.$id,
            'max:17',
            'regex:/^(([a-fA-F0-9]{2}-){5}[a-fA-F0-9]{2}|([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}|([0-9A-Fa-f]{4}\.){2}[0-9A-Fa-f]{4})?$/'
            ]

          ]);

        $data->sap_id = $request->sap_id;
        $data->host_name = $request->host_name;
        $data->mac_address = $request->mac_address;
        $data->save();
        return response()->json([ 'msg' => 'record updated successfully' ]);
      } else {
        return response()->json([ 'msg' => 'Record not found' ], 404);
      }
    }
}
