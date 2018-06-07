<?php

/* Chat line is used for the chat entries */

class ChatLine extends ChatBase{
	
//	protected $text = '', $author = '', $gravatar = '';
	protected $message = '', $name = '', $photo = '';
	
	public function save(){
		DB::query("
			INSERT INTO publicChat (name, photo, message)
			VALUES (
				'".DB::esc($this->name)."',
				'".DB::esc($this->photo)."',
				'".DB::esc($this->message)."'
		)");
		
		// Returns the MySQLi object of the DB class
		
		return DB::getMySQLiObject();
	}
}

?>
