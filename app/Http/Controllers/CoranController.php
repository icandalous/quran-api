<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoranController extends Controller
{
    protected $data = array();
  
   public function index(){
	  
	  return response()->json($this->getData(), 200);
	}
	
	public function sourate($idSourate){
		$this->data = $this->getSourate($idSourate);
		if(!empty($this->data)){
			return response()->json($this->data, 200);
		}
		
		
	}
	  
  public function getData(){
	  $str = file_get_contents(base_path('datajson/surah.json'));
	  $this->data = json_decode($str, true);
	  return $this->data;
  }
  
  public function getSourate($id){
	   $str = file_get_contents(base_path('datajson/surah/surah_'.$id.'.json'));
	  
	  return json_decode($str, true);
  }
}
