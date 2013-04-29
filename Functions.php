<?php

function InsertFurnitures()
{
    $folders = scandir("upload/furnitures");
    foreach ($folders as $folder)
    {
        if ($folder == "." || $folder == "..") continue;
        echo $folder."<br/>";
        $files = scandir("upload/furnitures/".$folder);
        sort($files, SORT_NUMERIC);
        $i = 0;
        $categoryId = 0;
        Switch ($folder)
        {
            case "displayWindows":
                $categoryId = 1;
                break;
            case "porcelains":
                $categoryId = 2;
                break;
            case "tables":
                $categoryId = 3;
                break;
            case "bars":
                $categoryId = 4;
                break;
            case "chandeliers":
                $categoryId = 5;
                break;
            case "chairs":
                $categoryId = 6;
                break;
            case "misc":
                $categoryId = 7;
                break;
            case "diningTables":
                $categoryId = 8;
                break;
            default:
                exit;
        }
        foreach ($files as $file)
        {
            if ($file == "Thumbs.db" || $file == "." || $file == "..") continue;
            $i++;

            $path = $file;
            echo $file."<br/>";
            $que = "INSERT INTO Furniture (IntOrder, CategoryId, ThumbPath, ImagePath)
               VALUES ($i, $categoryId, '".$path."', '".$path."')";
            mysql_query($que) or die('Query failure:' .$que."<br/>".mysql_error());
        }
        echo "<br/>";
    }
}

function DateTimeToDate($pDateTime)
{
	return date("d/m/Y", strtotime($pDateTime));
}

function GetShortString($pLongString, $pNewLength)
{
    $shortString = $pLongString;
    if (strlen($pLongString) > $pNewLength)
    {
        $shortString = mb_strcut($shortString, 0, $pNewLength - 3, "UTF-8")."...";
    }

    return $shortString;
}

function GetFurnitureCategories($pFirstCategory = 0, $pLastCategory = 0)
{
	$que = "SELECT F.Id, F.IntOrder, F.Title, F.SubTitle, F.Text, F.Image, F.TitleBgColor, F.Url
			FROM FurnitureCategory F
			WHERE F.IsVisible = 1
			ORDER BY F.IntOrder";
	$que .= $pFirstCategory > 0 && $pLastCategory > 0 ? " LIMIT ".($pFirstCategory - 1).", ".$pLastCategory."" : "";
			
	$sql = mysql_query($que) or die('Query failure:' .mysql_error()); 
	while ($row = mysql_fetch_assoc($sql))
	{
		$categories[$row['IntOrder']] = $row;
	}
	
	return $categories;
}

function GetSeoData($pPageTitle)
{
    if (!isset($pPageTitle)) return;

    $tmp = explode("/", $pPageTitle);
    if (count($tmp) > 1)
    {
        $pPageTitle = $tmp[count($tmp) - 1];
    }

    $que = "SELECT *
			FROM Page P
			WHERE P.Title = '".$pPageTitle."'";
    $sql = mysql_query($que) or die('Query failure:' .mysql_error());
    return mysql_fetch_assoc($sql);
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
            global $PAGE_ID;
            $PAGE_ID = $pSeoData['Id'];
            include('StaticPage.php');
            return;
        }
        else if (isset($pSeoData['Url']))
        {
            include($pSeoData['Url']);
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