<?php
// test-fcgi.php - a sample FCGI client
/*
 * Klasse zur Kommunikation mit dem FCGI-Client
 * @author Dirk Müller
 *
 */

define('FCGI_VERSION_1', 1);
define('FCGI_BEGIN_REQUEST', 1);
define('FCGI_ABORT_REQUEST', 2);
define('FCGI_END_REQUEST', 3);
define('FCGI_PARAMS', 4);
define('FCGI_STDIN', 5);
define('FCGI_STDOUT', 6);
define('FCGI_STDERR', 7);
define('FCGI_DATA', 8);
define('FCGI_GET_VALUES', 9);
define('FCGI_GET_VALUES_RESULT', 10);

define('FCGI_RESPONDER', 1);
define('FCGI_KEEP_CONN', 1);

class FCGI {

  public $host = 'localhost';
  public $port = 8002;

  /**
   * Constructor for FCGI Class
   * @param string $host default localhost
   * @param int $port    default 8002
   */
  public function __construct($host = 'localhost', $port = 8002) {
    $this->host = $host;
    $this->port = $port;
  }

  function FCGI_Packet($type, $content)
  {
    $len=strlen($content);
    $packet=chr(FCGI_VERSION_1).chr($type).chr(0).chr(1).chr((int)($len/256)).chr($len%256).chr(0).chr(0).$content;
    return($packet);
  }

  function FCGI_NVPair($name, $value)
  {
    $nlen = strlen($name);
    $vlen = strlen($value);

    if ($nlen < 128)
    $nvpair = chr($nlen);
    else
    $nvpair = chr(($nlen >> 24) | 0x80) . chr(($nlen >> 16) & 0xFF) . chr(($nlen >> 8) & 0xFF) . chr($nlen & 0xFF);

    if ($vlen < 128)
    $nvpair .= chr($vlen);
    else
    $nvpair .= chr(($vlen >> 24) | 0x80) . chr(($vlen >> 16) & 0xFF) . chr(($vlen >> 8) & 0xFF) . chr($vlen & 0xFF);

    return $nvpair . $name . $value;
  }

  function FCGI_Decode($data)
  {
    if( strlen($data) < 8 )
    die("Packet too small " . strlen($data) . "\n");

    $length = (ord($data{4}) << 8)+ord($data{5});
    $packet = Array( 'version' => ord($data{0}),
                   'type'    => ord($data{1}),
                   'length'  => $length,
                   'content' => substr($data, 8, $length) );

    return $packet;

  }

  function FCGI_Connect($host, $port) {
    // Connect to FastCGI server
    try {
      $socket = @fsockopen($host, $port, $errno, $errstr, 5);
    }
    catch (Exception $e) {
      // echo ("Failed to connect to $host:$port\n");
      return null;
    }
    return $socket;
  }

  function QueryIgnoreReturndata($filename, $get = array())
  {
    $socket = null;
    //connect
    $socket = $this->FCGI_Connect($this->host, $this->port);


    if ($socket) {
      // Begin session
      $packet = '';
      $packet .= $this->FCGI_Packet(FCGI_BEGIN_REQUEST, chr(0).chr(FCGI_RESPONDER).chr(FCGI_KEEP_CONN).chr(0).chr(0).chr(0).chr(0).chr(0) );

      // Build params

      $querystring = '';
      foreach($get as $g => $k) {
        if ($querystring != '') $querystring .= "&";
        $querystring .= urlencode($g) . "=" . urlencode($k);
      }

      $params = '';
      $params .= $this->FCGI_NVPair('GATEWAY_INTERFACE', 'FastCGI/1.0');
      $params .= $this->FCGI_NVPair('REQUEST_METHOD', 'GET');
      $params .= $this->FCGI_NVPair('SCRIPT_FILENAME', $filename);
      $params .= $this->FCGI_NVPair('QUERY_STRING', $querystring);

      $packet .= $this->FCGI_Packet(FCGI_PARAMS, $params);
      $packet .= $this->FCGI_Packet(FCGI_PARAMS, null);

      $packet .= $this->FCGI_Packet(FCGI_STDIN, null);

      fwrite($socket, $packet);

      //disconnect
      fclose($socket);
    }
  }

  function FCGI_Response($socket)
  {
    // Read answers from fastcgi server
    while(true)
    {
      if(feof($socket))
      die("Socket closed\n");
      $packet = fread($socket, 8);
      if( $packet === false )
      die("Read failed\n");
      $header = $this->FCGI_Decode($packet);
      //print_r($header);
      $len=$header['length']%8;
      $padlen=($len?(8-$len):0);
      $packet .= fread($socket, $header['length']+$padlen);
      $response = $this->FCGI_Decode($packet);
      if( $response['type'] == FCGI_END_REQUEST )
      break;
      else
      print "[{$response['type']}] [{$response['content']}]\n";
    }
  }
}
