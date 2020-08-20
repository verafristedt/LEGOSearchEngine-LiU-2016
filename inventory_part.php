<?php include("search_menu.html"); ?>

	<div class ="itemContainer">

		<?php
			//Establish connection with the database
			$connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");

			//If unable to connect display error message
			if (!$connection) die('MySQL connection error');

			//Get the PartID & ColorID from the webpage link created by choose_part.php
			$PartID = $_GET['PartID'];
			$ColorID = $_GET['ColorID'];

			//Set default page
			$Page = 1;
			//If set fetch pagenumber from GET
			if (isset($_GET['Page']))$Page = $_GET['Page'];

			//Rootlink to all images
			$link = "http://weber.itn.liu.se/~stegu76/img.bricklink.com";

			//Query to get information about the chosen part
			$setsearch = mysqli_query($connection, "SELECT parts.PartID, parts.Partname, colors.Colorname FROM parts,
													colors WHERE parts.PartID='$PartID' AND colors.ColorID='$ColorID'");

			//Print information and image about the part
			while($setinfo = mysqli_fetch_array($setsearch))
			{
				$imagesearch = mysqli_query($connection, "SELECT * FROM images WHERE ItemID='$PartID' AND ColorID='$ColorID'
														  AND ItemTypeID='P'");

				$imageinfo = mysqli_fetch_array($imagesearch);

				if($imageinfo['has_jpg']) { // Use JPG if it exists
					$filename = "$link/P/$ColorID/$PartID.jpg";
				}
				else if($imageinfo['has_gif']) { // Use GIF if JPG is unavailable
					$filename = "$link/P/$ColorID/$PartID.gif";
				}
				else { // If neither format is available, insert a placeholder image
					$filename = "error.png";
				}

				echo "<div id='legoItem'>";
				echo "<span class='legoItemImgContainer'>";
				echo "<img src='".$filename."' alt='Image does not exist'>";
				echo "</span>";

				echo "<div class='infoText'>
						<p class='legoName'>".$setinfo["Partname"]."</p>
						<p class='legoID'><span>ID: </span>".$PartID."</p>
						<p class='legoID'><span>Color: </span>".$setinfo["Colorname"]."</p>
					 </div>";
			 	echo "</div>";
			}

			//Print header and sort form
			echo "<p id ='ListItemParts'>This item is part of the following sets:</p><div id='allParts'>";

			echo "<form name='sortForm' method='POST'>
				 <select name='sortForm'>
				 <option value='Setname'>Choose a sorting option</option>
				 <option value='Setname ASC'>Name Ascending</option>
				 <option value='Setname DESC'>Name Descending</option>
				 <option value='SetID ASC'>ID-number Ascending</option>
				 <option value='SetID DESC'>ID-number Descending</option>
				 <option value='Quantity ASC'>Quantity Ascending</option>
				 <option value='Quantity DESC'>Quantity Descending</option>
				 </select>
				 <input type = 'submit' value = 'Sort' />
				 </form>";

			//Set default sorting
			$sort = "Setname";
			//If coming from another page, fetch sorting option from GET
			if (isset($_GET['Sort'])) $sort = $_GET['Sort'];
			//If sorting option has been chosen from sortForm on the current page
			if (isset($_POST['sortForm'])) $sort = $_POST['sortForm'];

			//Query to count all items in the chosen set
			$result = mysqli_query($connection, "SELECT parts.Partname, parts.PartID, colors.Colorname, inventory.Quantity,
									sets.Setname, sets.SetID FROM sets, inventory, colors, parts WHERE parts.PartID='$PartID'
									AND parts.PartID=inventory.ItemID AND inventory.ColorID='$ColorID' AND inventory.SetID=
									sets.SetID AND inventory.ColorID=colors.ColorID ORDER BY $sort");

			$counter = 0;
			$max_per_page = 20;

			while($row = mysqli_fetch_array($result)) {
				$counter++;
			}

			//Calculate how many pages to display
			$total_pages = floor($counter / $max_per_page) + 1;

			//Depending on page number, calculate starting point for LIMIT in the query
			$limit_start = ($Page * $max_per_page) - $max_per_page;

			//Query to fetch all results on current page
			$pageresult = mysqli_query($connection, "SELECT parts.Partname, parts.PartID, colors.Colorname, inventory.Quantity,
									sets.Setname, sets.SetID FROM sets, inventory, colors, parts WHERE parts.PartID='$PartID'
									AND parts.PartID=inventory.ItemID AND inventory.ColorID='$ColorID' AND inventory.SetID=
									sets.SetID AND inventory.ColorID=colors.ColorID ORDER BY $sort LIMIT $limit_start, $max_per_page");

			//Print result content
			while($row = mysqli_fetch_array($pageresult))
			{
				$SetID = $row['SetID'];

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

				echo "<a class='legoListItem' href='inventory_set.php?SetID=".$SetID."'>";
				echo "<div>";
				echo "<img src='".$filename."' alt='Image does not exist'>";
				echo "<div>";
				echo "<p class='legoListItemTitle'>".$row["Setname"]."</p>";
				echo "<p class='legoListItemId'><span>ID: </span>".$row["SetID"]."</p>";
				echo "<p><span>Quantity: </span>".$row["Quantity"]."</p>";
				echo "</div>";
				echo "</div>";
				echo "</a>";
			}
			echo "</div>";
			//Create link for page navigation
			$link_search = "inventory_part.php?PartID=".$PartID."&ColorID=".$ColorID."&Sort=".$sort;
			include("page_navigation.php");

			mysqli_close($connection);
		?>

		</div>
	</div>
	</body>
</html>
