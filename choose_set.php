<?php include("search_menu.html"); ?>

  <div id="itemContainer">

    <?php
		//Establish connection with the database
		$connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");

		//If unable to connect display error message
		if (!$connection) die('MySQL connection error');

		//Set default page
		$Page = 1;
		//If set fetch pagenumber from GET
		if (isset($_GET['Page'])) $Page = $_GET['Page'];

		//Rootlink to all images
		$link = "http://weber.itn.liu.se/~stegu76/img.bricklink.com";

		//Filtered user input
		$keyword = mysqli_real_escape_string($connection, $_POST["keyword"]);
		//Fetch keyword when sorting
		if (isset($_POST['oldKeyword'])) $keyword = $_POST['oldKeyword'];
		//Fetch keyword when changing page
		if (isset($_GET['Keyword'])) $keyword = $_GET['Keyword'];

		//Set default sorting
		$sort = "Setname";
		//If coming from another page, fetch sorting option from GET
		if (isset($_GET['Sort'])) $sort = $_GET['Sort'];

		//Query to count all items with the chosen keyword
		$result = mysqli_query($connection, "SELECT Setname, SetID FROM sets WHERE (SetID LIKE '%$keyword%'
											OR Setname LIKE '%$keyword%') ORDER BY $sort");

		$counter = 0;
		$max_per_page = 20;

		while($row = mysqli_fetch_array($result)) {
			$counter++;
		}

		//If no results were found, display error message
		if ($counter == 0) {
			include("error_message.php");
		}
		else { //Print header and sort form
			echo "<p id ='amountParts'>These sets contain the keyword: <span>".$keyword."</span></p>";
			echo "<div id='allParts'>";

			echo "<form name='sortForm' method='POST'>
				<select name='sortForm'>
				<option value='Setname'>Choose a sorting option</option>
				<option value='Setname ASC'>Name Ascending</option>
				<option value='Setname DESC'>Name Descending</option>
				<option value='SetID ASC'>ID-number Ascending</option>
				<option value='SetID DESC'>ID-number Descending</option>
				</select>
				<input type='hidden' name='oldKeyword' value='".$keyword."'/>
				<input type = 'submit' value = 'Sort' />
				</form>";

			//If sorting option has been chosen from sortForm on the current page
			if (isset($_POST['sortForm'])) $sort = $_POST['sortForm'];

			//Calculate how many pages to display
			$total_pages = floor($counter / $max_per_page) + 1;

			//Depending on page number, calculate starting point for LIMIT in the query
			$limit_start = ($Page * $max_per_page) - $max_per_page;

			//Query to fetch all results on current page
			$pageresult = mysqli_query($connection, "SELECT Setname, SetID FROM sets WHERE (sets.SetID LIKE '%$keyword%'
													 OR sets.Setname LIKE '%$keyword%') ORDER BY $sort LIMIT $limit_start,
													 $max_per_page");

			//Print result content
			while($row = mysqli_fetch_array($pageresult) AND $keyword != NULL)
			{
				$SetID = $row['SetID'];
				$Setname = $row['Setname'];

				$imagesearch = mysqli_query($connection, "SELECT * FROM images WHERE ItemTypeID='S' AND ItemID='$SetID'");

				$imageinfo = mysqli_fetch_array($imagesearch);

				if($imageinfo['has_jpg']) { // Use JPG if it exists
					$filename = "$link/S/$SetID.jpg";
				}
				else if($imageinfo['has_gif']) { // Use GIF if JPG is unavailable
					$filename = "$link/S/$SetID.gif";
				}
				else { // If neither format is available, insert a placeholder image
					$filename = "error.png";
				}

				echo "<a class='legoListItem' href='inventory_set.php?SetID=".$SetID."'>"; //Link to the displayed set
				echo "<div>";
				echo "<img src='".$filename."' alt='Image does not exist'alt='Image does not exist'>";
				echo "<div>
  					 <p class='legoListItemTitle'>".$Setname."</p>
  					 <p class='legoListItemId'><span>id: </span>".$SetID."</p>
  					 </div>";
				echo "</div>";
				echo "</a>";
			}
      echo "</div>";
			//Create link for page navigation
			$link_search = "choose_set.php?Keyword=".$keyword."&Sort=".$sort;
			include("page_navigation.php");
		}
		mysqli_close($connection);
    ?>

	</div>
	</div>
  </body>
</html>
