<?php
function DateTimeToDate($pDateTime)
{
	return date("d/m/Y", strtotime($pDateTime));
}

function GetShortString($pLongString, $pNewLength)
{
    return (strlen($pLongString) >= $pNewLength) ? mb_substr($pLongString, 0, $pNewLength, "utf-8")."..." : $pLongString;
}

function GetFurnitureCategories($pFirstCategory = 0, $pLastCategory = 0)
{
	$que = "SELECT F.Id, F.Order, F.Title, F.SubTitle, F.Text, F.Image, F.TitleBgColor, F.Url
			FROM FurnitureCategory F
			WHERE F.IsVisible = 1
			ORDER BY F.Order";
	$que .= $pFirstCategory > 0 && $pLastCategory > 0 ? " LIMIT ".($pFirstCategory - 1).", ".$pLastCategory."" : "";
			
	$sql = mysql_query($que) or die('Query failure:' .mysql_error()); 
	while ($row = mysql_fetch_assoc($sql))
	{
		$categories[$row['Order']] = $row;
	}
	
	return $categories;
}

function GetSeoData($pPageTitle)
{
    if (!isset($pPageTitle)) return;
    $que = "SELECT M.PageId as PageId, M.Url as OuterUrl, P.IsStatic, P.Url as InnerUrl
			FROM MenuItem M LEFT JOIN Page P ON (M.PageId = P.Id)
			WHERE M.Title = '".$pPageTitle."'";
    $sql = mysql_query($que) or die('Query failure:' .mysql_error());
    $seoData = mysql_fetch_assoc($sql);
    return $seoData;
}

function GenContent($pSeoData)
{
    if (!isset($pSeoData) || count($pSeoData) == 0)
    {
        include('Main.php');
        return;
    }
    else if (count($pSeoData) > 0)
    {
        if ($pSeoData['IsStatic'])
        {
            return;
        }
        else if (isset($pSeoData['InnerUrl']))
        {
            include($pSeoData['InnerUrl']);
            return;
        }
    }

    include('Main.php');
    return;
}

function GetPageTypeId($pPageTypeName)
{
    if (!isset($pPageTypeName)) return;
    $que = "SELECT P.Id
            FROM PageType P
            WHERE P.Name = '".$pPageTypeName."'";
    $sql = mysql_query($que) or die('Query failure:' .mysql_error());
    list($pageTypeId) = mysql_fetch_row($sql);
    return $pageTypeId;
}