<?php
global $PAGE_ID;
$page = GetPage($PAGE_ID);
?>

<div>
    <?php
    switch ($page['PageType'])
    {
        case 1:
            GenArticle($page);
            break;
        default:
            echo $page['Html'];
            break;
    }
    ?>
</div>

<?php
function GetPage($pPageId)
{
    if ($pPageId == -1) return;

    $que = "SELECT *
			FROM Page P
			WHERE P.Id = ".$pPageId;

    $sql = mysql_query($que) or die('Query failure:' .mysql_error());
    return mysql_fetch_assoc($sql);
}

function GenArticle($pPage)
{   ?>
    <h1><?php echo $pPage['Title']?></h1>
    <div>פורסם ב-<?php echo DateTimeToDate($pPage['PublishedDate'])?></div>
    <h4 style="margin-top: 20px"><?php echo $pPage['ShortDescription']?></h4>
    <div style="margin-top: 20px"><?php echo $pPage['Html']?></div>
    <?php
}