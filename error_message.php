<?php
	//Error message if no result where found
	echo "<div id='resultError'>
			<p class='wrongSearch'>Whoopsi daisy! <span>".$keyword."</span> didn't match any results.</p>
			<p class='wrongSearchHeader'>Suggestions:</p>
			<ul>
				<li>Searches containing multiple keywords must be in <span>chronological order.</span></li>
				<li>Make sure any specified measurements are written in this<span> syntax (ex. 2 x 2).</span></li>
				<li>Make sure that all words are spelled correctly.</li>
				<li>Try another search phrase.</li>
			</ul>
		</div>";
?>
