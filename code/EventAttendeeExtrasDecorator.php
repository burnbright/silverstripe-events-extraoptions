<?php
class EventAttendeeExtrasDecorator extends DataObjectDecorator{
	
	function extraStatics(){
		return array(
			'many_many' => array(
				'ExtraOptions' => 'EventExtraOption'
			)
		);
	}
	
	//CMS fields to show what extras have been chosen.
	function updateCMSFields(&$fields){
		
		if($extras = $this->owner->ExtraOptions() && $this->owner->ExtraOptions()->exists()){
			$filter = "ID IN (".implode(',',$this->owner->ExtraOptions()->map('ID','ID')).")";			
			$tlf = new TableListField('Extras','EventExtraOption',array('Name'=>'Name','Price'=>'Price'),$filter);
			$fields->addFieldToTab('Root.ChosenExtras',$tlf);			
		}
		
	}
}
?>
