<?php
class EventAttendeeExtrasDecorator extends DataObjectDecorator{
	
	function extraStatics(){
		return array(
			'many_many' => array(
				'ExtraOptions' => 'EventExtraOption'
			)
		);
	}
	
	//TODO: CMS fields to show what extras have been chosen.
	
}
?>
