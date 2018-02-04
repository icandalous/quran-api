<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MutashabController extends Controller
{
    protected $data = array();
  
   public function index(){
	  
	  return response()->json($this->getData(), 200);
	}
	
	public function mutashab($id){
		$this->data = $this->getMutashab($id);
		if(!empty($this->data)){
			return response()->json($this->data, 200);
		}
		
		
	}
	  
  public function getData(){
	  $str = file_get_contents(base_path('datajson/mutashab.json'));
	  $this->data = json_decode($str, true);
	  return $this->data;
  }
  
  public function getMutashab($id){
	   $str = $this->getData();
	  
	  return $str[$id-1];
  }
  
  public function getAllAyat(){
	  $str = file_get_contents(base_path('datajson/quran_details.json'));
	  $data = json_decode($str, true);
	  return $data;
  }
  
  public function getAyatsSummary(){
	  $str = file_get_contents(base_path('datajson/quran_summary.json'));
	  $data = json_decode($str, true);
	  return $data;
  }
  
  public function search($str){
	  $result= array();
	  $ids = array();
	  
	   $ayats = $this->searchAyat($str);
	   foreach($ayats as $index => $ayahInfo ){
		   if($ayahInfo['mutashab-id'] != -1 && !in_array($ayahInfo['mutashab-id'], $ids)){
			   array_push($ids, $ayahInfo['mutashab-id']);
			   $mutashabs = $this->getData();
			   if(isset($mutashabs[$ayahInfo['mutashab-id']-1])){
				   $mutashab = $mutashabs[$ayahInfo['mutashab-id']-1];
				   //array_push($ids, $index);
				   foreach($mutashab['data'] as &$item){
					   //var_dump($item);
						$quran_data = $this->getAllAyat();
						foreach($quran_data as $pos =>$line){
							if($line['chapter_number'] == $item['sourate_num'] && $line['Ayah_number'] == $item['ayat_num']){
								$item["ayahid"]= $line['ayahid'];
								$item["page-tag"]= $line['page-tag'];
								$item["pageid"]= $line['pageid'];
								$item["rubuhizbid"]= $line['rubuhizbid'];
								$item["hizbid"]= $line['hizbid'];
								$item["juzid"]= $line['juzid'];
								$item["sura name"] = $line["sura name"];
								$item["content_ar"] = $line["content_ar"];
							}
						}
						
					}
				   array_push($result, $mutashab);
				   
			   }
			  
			}  
	   }
	  return $result;
  }
  
  public function searchAyat($str){
	  $result= array();
	  
	  $str = MutashabController::stripAccent($str);
	  
	   $data = $this->getAllAyat();
	   foreach($data as $index => $ayahInfo ){
		   $ayah = $this->stripAccent($ayahInfo['content_ar']);
		    if (strstr($ayah, $str) != false){
				array_push($result, $ayahInfo);
			}
	   }
	  return $result;
  }
  public function getMutashabId($ayats){
	  
	  $result = array();
	  foreach($ayats as $index => $ayahInfo){
		if($ayats[mutashab-id] != -1){
		  array_push($result, $ayahInfo);
		}  
	  }
	  
	  return result;
	  
  }
  
  public static function stripAccent($string){
	$remove = array('ِ', 'ُ', 'ٓ', 'ٰ', 'ْ', 'ٌ', 'ٍ', 'ً', 'ّ', 'َ');
	$string = str_replace($remove, '', $string);
	
	return $string;

  }
  
  public function update(){
	$quran_data = $this->getAllAyat();
	$mutashab = $this->getData();
	
	foreach($mutashab as $i => $data ){
		$index = $data["index"];
		var_dump($index);
		foreach($data as $k => $item){
			//var_dump($item);
			$quran_data[$index-1]['mutashab-id'] = $item["indice"];
		}
		    
	}
	
	//Convert updated array to JSON
	   $jsondata = json_encode($quran_data, JSON_PRETTY_PRINT);
	   
	   //write json data into data.json file
	   if(file_put_contents(base_path('datajson/quran_details_new.json'), $jsondata)) {
	        echo 'Data successfully saved';
	   }
	   else 
	        echo "error";
  }
}
