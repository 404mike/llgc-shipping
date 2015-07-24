<?php

/**
 * 
 */

require('php-excel-reader/excel_reader2.php');

require('SpreadsheetReader.php');

class Ingest {

  public function __construct()
  {
    $this->iterateFiles();
  }

  /**
   * Loop through all the files is in the data directory
   * @return null
   */
  private function iterateFiles()
  {
    $path = realpath('../data');

    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

    // Loop through all the spreasheets
    foreach($objects as $name => $object){
        
      if(!is_dir($name)) {

        $pathArr = explode('/', $name);

        if(!isset($pathArr[7])) continue;

        $id = preg_replace('/File_(.*?)_(.*?)\.xlsx/', '$2', $pathArr[7]);

        $this->createShipDocument($name , $id);
        $this->createCrewDocument($name , $id);
      }
    }    
  }

  /**
   * @param  string $path
   * @param  string $id
   * @return null
   */
  private function createCrewDocument($path , $id)
  {
    try{
      $reader = new SpreadsheetReader($path);
      $sheets = $reader->Sheets();

      $parentId = $id;

      foreach ($sheets as $index => $name)
      {
        $page = $index;

        $reader -> ChangeSheet($index);

        
        foreach ($reader as $row => $value)
        {
          // $childId = '';
          if(empty($value[0])) continue;
          if($value[0] == "Mariner's name") continue;
          if($value[0] == "John Williams") continue;
          if($value[0] == "Edward Jones") continue;
          else{
            // Create XML document
            $xml_main = new SimpleXMLElement('<add/>');
            $xml = $xml_main->addChild('doc');
              
            $id = $xml->addChild('field' , $parentId.'_'.$page.'_'.$row);
            $id->addAttribute('name', 'id');

            $id = $xml->addChild('field' , 'sailor');
            $id->addAttribute('name', 'type');               

            $parent = $xml->addChild('field' , $parentId);
            $parent->addAttribute('name' , 'parent');

            $name = $xml->addChild('field' , htmlspecialchars($value[0]));
            $name->addAttribute('name' , 'name');

            $dob = $xml->addChild('field' , htmlspecialchars($value[1]));
            $dob->addAttribute('name' , 'dob');

            $age = $xml->addChild('field' , htmlspecialchars($value[2]));
            $age->addAttribute('name' , 'age');

            $place_of_birth = $xml->addChild('field' , htmlspecialchars($value[3]));
            $place_of_birth->addAttribute('name' , 'place_of_birth');

            $home_address = $xml->addChild('field' , htmlspecialchars($value[4]));
            $home_address->addAttribute('name' , 'home_address');

            $name_of_ship = $xml->addChild('field' , htmlspecialchars($value[6]));
            $name_of_ship->addAttribute('name' , 'name_of_ship');

            $ship_port = $xml->addChild('field' , htmlspecialchars($value[7]));
            $ship_port->addAttribute('name' , 'ship_port');

            $date_leaving = $xml->addChild('field' , htmlspecialchars($value[8]));
            $date_leaving->addAttribute('name' , 'date_leaving');

            $joined_ship_date = $xml->addChild('field' , htmlspecialchars($value[9]));
            $joined_ship_date->addAttribute('name' , 'joined_ship_date');

            $joined_at_port = $xml->addChild('field' , htmlspecialchars($value[10]));
            $joined_at_port->addAttribute('name' , 'joined_at_port');

            $capacity = $xml->addChild('field' , htmlspecialchars($value[11]));
            $capacity->addAttribute('name' , 'capacity');

            $date_left = $xml->addChild('field' , htmlspecialchars($value[12]));
            $date_left->addAttribute('name' , 'date_left');

            $left_port = $xml->addChild('field' , htmlspecialchars($value[13]));
            $left_port->addAttribute('name' , 'left_port');

            $cause_of_leaving = $xml->addChild('field' , htmlspecialchars($value[14]));
            $cause_of_leaving->addAttribute('name' , 'cause_of_leaving');

            $sign_with_mark = $xml->addChild('field' , htmlspecialchars($value[15]));
            $sign_with_mark->addAttribute('name' , 'sign_with_mark');

            $notes = $xml->addChild('field' , htmlspecialchars($value[16]));
            $notes->addAttribute('name' , 'notes');

            // Header('Content-type: text/xml');
            $this->sendToSolr($xml_main->asXML());
            // print($xml_main->asXML());
          }  
        }
      }

    }catch  (Exception $e) {
      echo "Could not read file";
    }    
  } 

  /**
   * @param  string $path
   * @param  string $id
   * @return null
   */
  private function createShipDocument($path , $id)
  {

    try{
      // echo "\n****** $id ******\n";
      // echo "\n****** $path ******\n";

      $reader = new SpreadsheetReader($path);
      $vessel_name = '';
      $ship_official_number = '';
      $port_of_registry = '';

      foreach ($reader as $row)
      {
        if($row[1] == 'Vessel Name :') {
          $vessel_name = $row[5];
        }
        elseif($row[1] == 'Ship Official number :') {
          $ship_official_number = $row[5];
        }
        elseif($row[1] == 'Port of Registry :') {
          $port_of_registry = $row[5];
        }
      }

      // Create XML document
      $xml_main = new SimpleXMLElement('<add/>');
      $xml = $xml_main->addChild('doc');
      
      $id = $xml->addChild('field' , $id);
      $id->addAttribute('name', 'id');

      $id = $xml->addChild('field' , 'log_book');
      $id->addAttribute('name', 'type');      

      $vessel_name = $xml->addChild('field' , htmlspecialchars($vessel_name));
      $vessel_name->addAttribute('name', 'vessel_name');

      $ship_official_number = $xml->addChild('field' , htmlspecialchars($ship_official_number));
      $ship_official_number->addAttribute('name', 'ship_official_number');

      $port_of_registry = $xml->addChild('field' , htmlspecialchars($port_of_registry));
      $port_of_registry->addAttribute('name', 'port_of_registry');

      // Header('Content-type: text/xml');
      // print($xml->asXML());
      $this->sendToSolr($xml_main->asXML());

    }catch(Exception $e) {
      echo "Could not read file";
    }
  }

  /**
   * @param  [type]
   * @return [type]
   */
  private function sendToSolr($file)
  {
    echo "semdmg";
    $url = "http://localhost:8983/solr/collection1/update?commit=true";
    $post_string = $file;

    $header = array("Content-type:text/xml; charset=utf-8");

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

    $data = curl_exec($ch);

    if (curl_errno($ch)) {
       print "curl_error:" . curl_error($ch);
    } else {
       curl_close($ch);
       print "curl exited okay\n";
       echo "Data returned...\n";
       echo "------------------------------------\n";
       echo $data;
       echo "------------------------------------\n";
    }
  }

}


new Ingest();


