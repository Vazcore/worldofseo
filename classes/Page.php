<?php
	/**
	* Klass dlya predstavleniya structury saita
	*/
	class Page 
	{
		private $page_type;
		
		function __construct($page_type)
		{
			$this->page_type = $page_type;
		}

		function get_header(){
			include("blocks/header.php");
		}

		function get_footer(){
			include("blocks/footer.php");
		}
	}
?>