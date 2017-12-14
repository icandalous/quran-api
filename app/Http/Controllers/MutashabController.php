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
	  
	   $ayats = $this->searchAyat($str);
	   foreach($ayats as $index => $ayahInfo ){
		   if($ayahInfo['mutashab-id'] != -1){
			   $mutashabs = $this->getData();
			   if(isset($mutashabs[$ayahInfo['mutashab-id']-1])){
				   array_push($result, $mutashabs[$ayahInfo['mutashab-id']-1]);
				   
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
}
