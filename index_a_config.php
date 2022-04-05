<?php
	switch ($_SERVER["SCRIPT_NAME"]) {
		
		case "index_contact.php":
			$CURRENT_PAGE = "Contact"; 
			$PAGE_TITLE = "Contact Us";
			break;
		default:
			$CURRENT_PAGE = "Index";
			$PAGE_TITLE = "BOIWS wita!";
	}
?>
