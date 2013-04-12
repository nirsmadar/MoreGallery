<?php
function DateTimeToDate($pDateTime)
{
	return date("d/m/Y", strtotime($pDateTime));
}

function GetFurnitureCategories($pFirstCategory = 0, $pLastCategory = 0)
{
	$que = "SELECT F.Id, F.Order, F.Title, F.SubTitle, F.Text, F.Image, F.IsVisible, F.TitleBgColor, F.Url
			FROM FurnitureCategory F
			ORDER BY F.Order";
	$que .= $pFirstCategory > 0 && $pLastCategory > 0 ? " LIMIT ".($pFirstCategory - 1).", ".$pLastCategory."" : "";
			
	$sql = mysql_query($que) or die('Query failure:' .mysql_error()); 
	while ($row = mysql_fetch_assoc($sql))
	{
		$categories[$row['Order']] = $row;
	}
	
	return $categories;
}