<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoranController extends Controller
{
    protected $data = array();
  
   public function index(){
	  
	  return response()->json($this->getData(), 200);
	}
	
	/************************************************************
	  Retourne la sourate du numero envoyé en paramètre.
	  @param idSourate : le numero de la sourate dans le quran
    *************************************************************/
	public function sourate($idSourate){
		$this->data = $this->getSourate($idSourate);
		if(!empty($this->data)){
			return response()->json($this->data, 200);
		}
		
		
	}
   /************************************************************************
	Récupérer tous les données des sourates dans le quran.
  *************************************************************************/
  public function getData(){
	  $str = file_get_contents(base_path('datajson/surah.json'));
	  $this->data = json_decode($str, true);
	  return $this->data;
  }
  
  /************************************************************
	  Retourne la sourate du numero envoyé en paramètre.
	  @param id : le numero de la sourate dans le quran
    *************************************************************/
  public function getSourate($id){
	  //TODO validation ID qui doit être entre 1 et 114 sinon BAD_REQUEST
	   $str = file_get_contents(base_path('datajson/surah/surah_'.$id.'.json'));
	  
	  return json_decode($str, true);
  }
}
