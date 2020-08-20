<?php
	echo"<div id='pageMeny'>";

	//Diplay of page navigation meny
	echo "<ul class='pageNavigation'>";

		//Display previous button only if not on first page
		if ($Page != 1) {
			echo "<li class='pageListButton'><a href='".$link_search."&Page=".($Page-1)."'>Previous</a></li>";
		}

		//Don't print page number if only one page
		if ($total_pages == 1) {
		}
		//If <= 10 pages print all pages
		else if ($total_pages <= 10) {
			for ($i = 1; $i <= $total_pages; $i++) {
				echo "<li class='pageList'><a href='".$link_search."&Page=".$i."'>".$i."</a></li>";
			}
		}
		//If the current page is <=6 print up to 10 pages
		else if ($Page <= 6) {
			for ($i = 1; $i <= 10; $i++) {
				echo "<li class='pageList'><a href='".$link_search."&Page=".$i."'>".$i."</a></li>";
			}
		}
		//If the current page is >= the 6th last page print the last 10 pages
		else if ($Page >= ($total_pages - 6)) {
			for ($i = ($total_pages - 10); $i <= $total_pages; $i++) {
				echo "<li class='pageList'><a href='".$link_search."&Page=".$i."'>".$i."</a></li>";
			}
		}
		//Else display 5 pages before and 5 after the current page
		else {
			for ($i = ($Page - 5); $i < ($Page + 5); $i++) {
				echo "<li class='pageList'><a href='".$link_search."&Page=".$i."'>".$i."</a></li>";
			}
		}

		//Display next button only if not on last page
		if (
		$Page != $total_pages) {
			echo "<li class='pageListButton'><a href='".$link_search."&Page=".($Page+1)."'>Next</a></li>";
		}

	echo "</ul>";

	echo "</div>";
	echo "<input type='hidden' value=".$Page." id='currentPageNum'>";
?>
