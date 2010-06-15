<?php
/**
 * Allows you to add extra options to an event.
 */


Object::add_extension('EventAttendee', 'EventAttendeeExtrasDecorator');
Object::add_extension('Event', 'EventExtrasDecorator');

?>