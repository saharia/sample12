<?php

namespace App\Http\Controllers;
use App\Router;

use Illuminate\Http\Request;

class RouterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $routers = Router::orderby('id', 'desc')->get();
        return view('router.index',compact('routers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('router.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //(([0-9A-Fa-f]{2}[-:]){5}[0-9A-Fa-f]{2})|(([0-9A-Fa-f]{4}\.){2}[0-9A-Fa-f]{4}) -- mac address
        ///^(\d+(\.|$)){4}/ - ipv4 validation
        $request->validate([
          'sap_id' => 'required|unique:routers|max:18|regex:/[0-9A-Za-z]/',
          'host_name' => 'required|unique:routers|max:14|regex:/[0-9A-Za-z]/',
          'loop_back' => 'required|unique:routers|max:45|ipv4',
          'mac_address' => [
            'required', 
            'unique:routers',
            'max:17',
            'regex:/^(([a-fA-F0-9]{2}-){5}[a-fA-F0-9]{2}|([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}|([0-9A-Fa-f]{4}\.){2}[0-9A-Fa-f]{4})?$/'
            ]
          ]);
          Router::create($request->all());
          return redirect()->route('routers.index')
          ->with('success','routers created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $router = Router::find($id);
        return view('router.show', compact('router'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $router = Router::find($id);
        return view('router.edit', compact('router'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
          Router::where('id', $id)->update($request->except([ '_token', '_method' ]));
          return redirect()->route('routers.index')
          ->with('success','routers updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = Router::find($id);
        if($data) {
          Router::find($id)->delete();
        }
        return redirect()->route('routers.index')
        ->with('success','router deleted successfully');
    }

    public function telnet() {
      
      // set up basic connection
      $ftp_server = '127.0.0.1';
      $ftp_user_name = 'Till';
      $ftp_user_pass = 'Kcp05';
      $conn_id = ftp_connect($ftp_server);
      // login with username and password
      ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
      // upload a file
      ftp_nb_put($conn_id, $remote_file, $file, FTP_ASCII);
      // close the connection
      echo "$file sent to $ftp_server as $remote_file\n<br/>";
      ftp_close($conn_id);


      // finished copying the input.dat to the till now, just need to execute the print command.
      // That will copy somefile.txt in the same folder as this .php file to the ftp server root dir.


      $header1=chr(0xFF).chr(0xFB).chr(0x1F).chr(0xFF).chr(0xFB).chr(0x20).chr(0xFF).chr(0xFB).chr(0x18).chr(0xFF).chr(0xFB).chr(0x27).chr(0xFF).chr(0xFD).chr(0x01).chr(0xFF).chr(0xFB).chr(0x03).chr(0xFF).chr(0xFD).chr(0x03).chr(0xFF).chr(0xFC).chr(0x23).chr(0xFF).chr(0xFC).chr(0x24).chr(0xFF).chr(0xFA).chr(0x1F).chr(0x00).chr(0x50).chr(0x00).chr(0x18).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x20).chr(0x00).chr(0x33).chr(0x38).chr(0x34).chr(0x30).chr(0x30).chr(0x2C).chr(0x33).chr(0x38).chr(0x34).chr(0x30).chr(0x30).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x27).chr(0x00).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x18).chr(0x00).chr(0x58).chr(0x54).chr(0x45).chr(0x52).chr(0x4D).chr(0xFF).chr(0xF0);

      $fp=pfsockopen("127.0.0.1",23);

      echo "Telnet session opening ...";

      sleep(4);

      fputs($fp,$header1); 
      sleep(4); 

      fputs($fp,"Till\r");
      sleep(2); 
      fputs($fp,"Kcp05\r"); 

      sleep(2);
      fputs($fp,"notepad\r"); 

      sleep(3);

      echo "Telnet session closing ...";

      fclose($fp);
    }

    public function ssh() {
      function my_ssh_disconnect($reason, $message, $language) {
        printf("Server disconnected with reason code [%d] and message: %s\n",
               $reason, $message);
      }
      
      $methods = array(
        'kex' => 'diffie-hellman-group1-sha1',
        'client_to_server' => array(
          'crypt' => '3des-cbc',
          'comp' => 'none'),
        'server_to_client' => array(
          'crypt' => 'aes256-cbc,aes192-cbc,aes128-cbc',
          'comp' => 'none'));
      
      $callbacks = array('disconnect' => 'my_ssh_disconnect');
      
      $connection = ssh2_connect('shell.example.com', 22, $methods, $callbacks);
      if (!$connection) die('Connection failed');
    }

    public function getFiles() {

      $ftp_server = '127.0.0.1';
      $ftp_user_name = 'Till';
      $ftp_user_pass = 'Kcp05';
      $conn_id = ftp_connect($ftp_server);
      // login with username and password
      ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
      // upload a file
      ftp_nb_put($conn_id, $remote_file, $file, FTP_ASCII);
      // close the connection
      echo "$file sent to $ftp_server as $remote_file\n<br/>";
      ftp_close($conn_id);


      // finished copying the input.dat to the till now, just need to execute the print command.
      // That will copy somefile.txt in the same folder as this .php file to the ftp server root dir.


      $header1=chr(0xFF).chr(0xFB).chr(0x1F).chr(0xFF).chr(0xFB).chr(0x20).chr(0xFF).chr(0xFB).chr(0x18).chr(0xFF).chr(0xFB).chr(0x27).chr(0xFF).chr(0xFD).chr(0x01).chr(0xFF).chr(0xFB).chr(0x03).chr(0xFF).chr(0xFD).chr(0x03).chr(0xFF).chr(0xFC).chr(0x23).chr(0xFF).chr(0xFC).chr(0x24).chr(0xFF).chr(0xFA).chr(0x1F).chr(0x00).chr(0x50).chr(0x00).chr(0x18).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x20).chr(0x00).chr(0x33).chr(0x38).chr(0x34).chr(0x30).chr(0x30).chr(0x2C).chr(0x33).chr(0x38).chr(0x34).chr(0x30).chr(0x30).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x27).chr(0x00).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x18).chr(0x00).chr(0x58).chr(0x54).chr(0x45).chr(0x52).chr(0x4D).chr(0xFF).chr(0xF0);

      $fp=pfsockopen("127.0.0.1",23);
      $path = $ftp_server.'/'.'sample/test';
      $files = scandir($imgspath); 						 
      $total = count($files); 
      return $total;
    }


    public function copyFiles() {

      $ftp_server = '127.0.0.1';
      $ftp_user_name = 'Till';
      $ftp_user_pass = 'Kcp05';
      $conn_id = ftp_connect($ftp_server);
      // login with username and password
      ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
      // upload a file
      ftp_nb_put($conn_id, $remote_file, $file, FTP_ASCII);
      // close the connection
      echo "$file sent to $ftp_server as $remote_file\n<br/>";
      ftp_close($conn_id);


      // finished copying the input.dat to the till now, just need to execute the print command.
      // That will copy somefile.txt in the same folder as this .php file to the ftp server root dir.


      $header1=chr(0xFF).chr(0xFB).chr(0x1F).chr(0xFF).chr(0xFB).chr(0x20).chr(0xFF).chr(0xFB).chr(0x18).chr(0xFF).chr(0xFB).chr(0x27).chr(0xFF).chr(0xFD).chr(0x01).chr(0xFF).chr(0xFB).chr(0x03).chr(0xFF).chr(0xFD).chr(0x03).chr(0xFF).chr(0xFC).chr(0x23).chr(0xFF).chr(0xFC).chr(0x24).chr(0xFF).chr(0xFA).chr(0x1F).chr(0x00).chr(0x50).chr(0x00).chr(0x18).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x20).chr(0x00).chr(0x33).chr(0x38).chr(0x34).chr(0x30).chr(0x30).chr(0x2C).chr(0x33).chr(0x38).chr(0x34).chr(0x30).chr(0x30).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x27).chr(0x00).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x18).chr(0x00).chr(0x58).chr(0x54).chr(0x45).chr(0x52).chr(0x4D).chr(0xFF).chr(0xF0);

      $fp=pfsockopen("127.0.0.1",23);
      $path = $ftp_server.'/'.'sample/test';
      $dstfile = 'G:\Shared\Reports\Joe.txt';
      mkdir(dirname($dstfile), 0777, true);
      copy($srcfile, $dstfile);

      return true;
    }

    public function diskFreeSpace() {

      $ftp_server = '127.0.0.1';
      $ftp_user_name = 'Till';
      $ftp_user_pass = 'Kcp05';
      $conn_id = ftp_connect($ftp_server);
      // login with username and password
      ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
      // upload a file
      ftp_nb_put($conn_id, $remote_file, $file, FTP_ASCII);
      // close the connection
      echo "$file sent to $ftp_server as $remote_file\n<br/>";
      ftp_close($conn_id);


      // finished copying the input.dat to the till now, just need to execute the print command.
      // That will copy somefile.txt in the same folder as this .php file to the ftp server root dir.


      $header1=chr(0xFF).chr(0xFB).chr(0x1F).chr(0xFF).chr(0xFB).chr(0x20).chr(0xFF).chr(0xFB).chr(0x18).chr(0xFF).chr(0xFB).chr(0x27).chr(0xFF).chr(0xFD).chr(0x01).chr(0xFF).chr(0xFB).chr(0x03).chr(0xFF).chr(0xFD).chr(0x03).chr(0xFF).chr(0xFC).chr(0x23).chr(0xFF).chr(0xFC).chr(0x24).chr(0xFF).chr(0xFA).chr(0x1F).chr(0x00).chr(0x50).chr(0x00).chr(0x18).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x20).chr(0x00).chr(0x33).chr(0x38).chr(0x34).chr(0x30).chr(0x30).chr(0x2C).chr(0x33).chr(0x38).chr(0x34).chr(0x30).chr(0x30).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x27).chr(0x00).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x18).chr(0x00).chr(0x58).chr(0x54).chr(0x45).chr(0x52).chr(0x4D).chr(0xFF).chr(0xF0);

      $fp=pfsockopen("127.0.0.1",23);
      $path = $ftp_server.'/'.'sample';
      $df = disk_free_space($path);

      return $df;
    }


    public function fileExtract() {

      $ftp_server = '127.0.0.1';
      $ftp_user_name = 'Till';
      $ftp_user_pass = 'Kcp05';
      $conn_id = ftp_connect($ftp_server);
      // login with username and password
      ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
      // upload a file
      ftp_nb_put($conn_id, $remote_file, $file, FTP_ASCII);
      // close the connection
      echo "$file sent to $ftp_server as $remote_file\n<br/>";
      ftp_close($conn_id);


      // finished copying the input.dat to the till now, just need to execute the print command.
      // That will copy somefile.txt in the same folder as this .php file to the ftp server root dir.


      $header1=chr(0xFF).chr(0xFB).chr(0x1F).chr(0xFF).chr(0xFB).chr(0x20).chr(0xFF).chr(0xFB).chr(0x18).chr(0xFF).chr(0xFB).chr(0x27).chr(0xFF).chr(0xFD).chr(0x01).chr(0xFF).chr(0xFB).chr(0x03).chr(0xFF).chr(0xFD).chr(0x03).chr(0xFF).chr(0xFC).chr(0x23).chr(0xFF).chr(0xFC).chr(0x24).chr(0xFF).chr(0xFA).chr(0x1F).chr(0x00).chr(0x50).chr(0x00).chr(0x18).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x20).chr(0x00).chr(0x33).chr(0x38).chr(0x34).chr(0x30).chr(0x30).chr(0x2C).chr(0x33).chr(0x38).chr(0x34).chr(0x30).chr(0x30).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x27).chr(0x00).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x18).chr(0x00).chr(0x58).chr(0x54).chr(0x45).chr(0x52).chr(0x4D).chr(0xFF).chr(0xF0);

      $fp=pfsockopen("127.0.0.1",23);
      $path = $ftp_server.'/'.'sample';

      $zip = Zip::create('file.zip');

      for($i = 0; $i <= 10; $i++) {
        $content = "some text here";
        $fp = fopen($path . "/myText.txt","wb");
        fwrite($fp,$content);
        fclose($fp);
        $zip->add($fp);
      }

      return response()->download($zip);
    }
}
