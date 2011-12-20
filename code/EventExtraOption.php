<?php
class EventExtraOption extends DataObject{
	
	static $db = array(
		'Name' => 'Varchar',
		'Description' =>'Varchar(255)',
		'Manipulation' => "Enum('Add,Subtract','Add')",
		'Price' => 'Currency'
		//TODO: quantity available
	);
	
	static $casting = array(
		'Title' => 'Varchar'
	);
	
	function Title(){
		if($this->Price){
			$price = DBField::create('Currency',$this->Price);
			return $this->Name." - "._t("EventExtraOption.".strtoupper($this->Manipulation),$this->Manipulation)." ".$price->Nice();
		}
		return $this->Name;
	}
	
	function manipulate($value){
		if($this->Price){
			switch($this->Manipulation){
				case 'Add':
					$value += $this->Price;
					break;
				case 'Subtract':
					$value -= $this->Price;
					break;
			}
		}
		return $value;
	}
}