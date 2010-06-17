<?php
class EventExtrasDecorator extends DataObjectDecorator{
	
	function extraStatics(){
		return array(
			'many_many' => array(
				'ExtraOptions' => 'EventExtraOption'
			)
		);
	}
	
	//update cms fields
	function updateCMSFields(&$fields){
		
		$fieldlist = array(
			'Name' => 'Name',
			'Description' => 'Description',
			'Manipulation' => 'Manipulation',
			'Price' => 'Price'
		);
		
		$ctf = new ManyManyComplexTableField($this->owner,'ExtraOptions','EventExtraOption',$fieldlist);
		$fields->addFieldToTab('Root.Content.Extras',$ctf);
		
		//TODO: finish this to show the number of extras in the CMS
		if(false && $af = $fields->fieldByName('Root')->fieldByName('Reports')->fieldByName('Attendees')->Fields()->fieldByName('AttendeesField')){
			$fields = $af->FieldList();
			$fields['NumberOfExtras'] = 'NumberOfExtras';
			$af->setFieldList($fields);
		}
		
	}
	
	//new cost calculation
	function updateAttendeeCost(&$cost, &$attendee){
		if($attendee->Extras){
			foreach($attendee->Extras as $extraid){
				if($this->owner->ExtraOptions()->containsIDs(array($extraid))){
					$extra = $this->owner->ExtraOptions()->find('ID',$extraid);
					$cost = $extra->manipulate($cost);
				}	
			}
		}
	}
	
	function updateRegistrationFields(FieldSet &$fields, &$actions, &$validator){
		if($this->owner->ExtraOptions() && $this->owner->ExtraOptions()->exists()){
			$csf = new CheckboxSetField('ExtraOptions','Additional',$this->owner->ExtraOptions()->map('ID','Title'));
			if($fields->fieldByName('Attendees') && $fields->fieldByName('Attendees') instanceof VariableGroupField){
				$fields->fieldByName('Attendees')->push($csf);
				$fields->fieldByName('Attendees')->generateFields();
			}else{
				$fields->push($csf);
			}
		}
	}
	
	/**
	 * Called by VariableGroupField callback
	 */
	function customAttendeesGeneration(&$attendee,$composite){
		if($composite->fieldByName('ExtraOptions')){
			$attendee->Extras = explode(',',$composite->fieldByName('ExtraOptions')->dataValue());
			if($attendee->ID){
				$attendee->ExtraOptions()->setByIDList($attendee->Extras);
			}
		}
	}
	
}
?>
