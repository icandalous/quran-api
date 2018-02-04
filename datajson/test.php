<?php

class Mutashab
{
  protected $data = array();
	  
  public function getData(){
	  $str = file_get_contents('mutashab.json');
	  $this->data = json_decode($str, true);
	  return $this->data;
  }
  
  public function getAllAyat(){
	  $str = file_get_contents('quran_details.json');
	  $data = json_decode($str, true);
	  return $data;
  }
  
  public function update(){
	$quran_data = $this->getAllAyat();
	$mutashablist = $this->getData();
	
	
	foreach($mutashablist as $i => $mutashab ){
		//var_dump($i);
		//var_dump($mutashab);
		$index = $mutashab["index"];
		//var_dump($index);
		foreach($mutashab['data'] as $item){
			//var_dump($item);
			$chap = 0;
			foreach($quran_data as $pos =>$line){
				if($line['chapter_number'] != $chap){
					$chap ++;
					//die(var_dump($item));
					if($chap == $item["sourate_num"]){
						$indice_ayat = $pos+$item["ayat_num"]-1;
						$quran_data[$indice_ayat]['mutashab-id'] = $item["indice"];
						var_dump($item);
					}
				}
			}
			
		}
		    
	}
	
	//Convert updated array to JSON
	   $jsondata = json_encode($quran_data,JSON_UNESCAPED_UNICODE);
	   //$jsondata = iconv("CP1257","UTF-8", $jsondata);
	   //write json data into data.json file
	   if(file_put_contents('quran_details_new.json', $jsondata)) {
	        echo 'Data successfully saved';
	   }
	   else 
	        echo "error";
  }
  
  public function resetAll(){
	$quran_data = $this->getAllAyat();
	
	foreach($quran_data as $i => $item ){
		$item['mutashab-id'] = -1;
		    
	}
	
	//Convert updated array to JSON
	   $jsondata = json_encode($quran_data, JSON_PRETTY_PRINT);
	   $jsondata = iconv("CP1257","UTF-8", $jsondata);
	   //write json data into data.json file
	   if(file_put_contents('quran_details_new.json', $jsondata)) {
	        echo 'Data successfully saved';
	   }
	   else 
	        echo "error";
  }
}

$m = new Mutashab();
//
$m->update();
//$m->resetAll();