<?php
	/**
	* Glavnyi class content - zadaiet napravlennost' v sozdanii tipov contenta
	*/
	class Content
	{
		protected $type;
		protected $text;		
		protected $author;
		protected $date_publishing;


		protected function setAuthor($author){
			$this->author = $author;
		}

		protected function setText($text){
			$this->text = $text;
		}

		
		protected function setDate($date_publishing){
			$this->date_publishing = $date_publishing;
		}

	}
?>