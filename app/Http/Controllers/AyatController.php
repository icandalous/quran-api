<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AyatController extends Controller
{
    protected $data = array();
  
  /***********************************************************
	Méthode principale pour retourner tous les ayats du quran.
  ************************************************************/
  public function index(){
	  $this->data = $this->getData();
	  //var_dump($this->data); die();
	  return response()->json($this->data, 200);
  }
  
  /************************************************************
  Retourne le ayat numero {id} du quran
  retourne tous les ayats si le id est null
  @param id : le numero du ayat dans le quran
  *************************************************************/
  public function ayats($id = null){
	  //TODO: Validation id entre 1 et total data
	  $this->data = $this->getData();
	  $ayat = $id !== null ? $this->data[$id-1] : $this->data;
	  return response()->json($ayat, 200);
  }
  
  /**********************************************************************
  Cette méthode recherche les ayats correspondant à la string recherchée.
  On enlève d'abord les accents avant de faire la comparaison des string.
  @param str : le ayat à rechercher
  ************************************************************************/
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
	
  /************************************************************************
	Récupérer tous les informations des ayats dans le quran.
  *************************************************************************/
  public function getData(){
	  $str = file_get_contents(base_path('datajson/quran_details.json'));
	  $this->data = json_decode($str, true);
	  return $this->data;
  }
  
  /************************************************************************
	Enlève les kharaqates (accents) dans la chaine en arabe.
  *************************************************************************/
  public function stripAccent($string){
	$remove = array('ِ', 'ُ', 'ٓ', 'ٰ', 'ْ', 'ٌ', 'ٍ', 'ً', 'ّ', 'َ');
	$string = str_replace($remove, '', $string);
	
	return $string;

  }
}
