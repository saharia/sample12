<?php

use Illuminate\Database\Seeder;
use App\Router;

class RouterSeeder extends Seeder
{
  protected $signature = 'app:seed {limit}';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private static $mac_address_vals = array(
      "0", "1", "2", "3", "4", "5", "6", "7",
      "8", "9", "A", "B", "C", "D", "E", "F"
   );

    public static function generateMacAddress()
    {
        $vals = self::$mac_address_vals;
        if (count($vals) >= 1) {
            $mac = array("00"); // set first two digits manually
            while (count($mac) < 6) {
                shuffle($vals);
                $mac[] = $vals[0] . $vals[1];
            }
            $mac = implode(":", $mac);
        }
        return $mac;
    }

    public function run($count)
    {
      echo $count;
        //
        if($count && is_numeric($count)) {
          for($i = 0; $i < $count; $i++) {
            $sap_id = Str::random(18);
            $host_name = Str::random(14);
            $loop_back = long2ip(mt_rand());
            $mac_address = self::generateMacAddress();
            $model = new Router;
            $data = [
              'sap_id' => $sap_id,
              'host_name' => $host_name,
              'loop_back' => $loop_back,
              'mac_address' => $mac_address
            ];
            $response = $model->insertData($data);
          }
        }
    }
}
