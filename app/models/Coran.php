<?php
 
class Coran  {
 
  protected $data = array();
  
  public function __construct(){
	  $str = file_get_contents(base_path('datajson/quran_summary.json');
	  $this->data = json_decode($str, true);
	  return $this->data;
  }
  
  public function getData(){
	  return $this->data;
  }
 
}