<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AyatController extends Controller
{
    protected $data = array();
  
  public function index(){
	  $this->data = $this->getData();
	  //var_dump($this->data); die();
	  return response()->json($this->data, 200);
  }
  
  public function ayats($id){
	  $this->data = $this->getData();
	  $ayat = $this->data[$id-1];
	  return response()->json($ayat, 200);
  }
  
  public function search($str){
	  $result= array();
	  
	  $str = $this->stripAccent($str);
	  
	   $this->data = $this->getData();
	   foreach($this->data as $index => $ayahInfo ){
		   $ayah = $this->stripAccent($ayahInfo['content_ar']);
		    if (strstr($ayah, $str) != false){
				array_push($result, $ayahInfo);
			}
	   }
	  return $result;
  }
	  
  public function getData(){
	  $str = file_get_contents(base_path('datajson/quran_details.json'));
	  $this->data = json_decode($str, true);
	  return $this->data;
  }
  
  public function stripAccent($string){
	$remove = array('ِ', 'ُ', 'ٓ', 'ٰ', 'ْ', 'ٌ', 'ٍ', 'ً', 'ّ', 'َ');
	$string = str_replace($remove, '', $string);
	
	return $string;

  }
}
