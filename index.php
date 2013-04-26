<?php
include "Constants.php";
include "DataBase.php";
include "Functions.php";
include "UiFunctions.php";

$pageTitle = isset($_GET['PageTitle']) ? $_GET['PageTitle'] : null;
$seoData = array();
if (isset($pageTitle)) $seoData = GetSeoData($pageTitle);
$title = isset($seoData['Title']) ? "מור גלרי | ".$seoData['Title'] : "מור גלרי | More Gallery";
?>
<!DOCTYPE HTML>
<html>
<head>
    <base href="<?php echo BASE_URL ?>/">
	<title><?php echo $title ?></title>
	<link rel="stylesheet" href="style.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
    <script type="text/javascript" src="scripts/megafolio/js/jquery.themepunch.plugins.min.js"></script>
	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>-->
	<?php include "MegafolioHead.html";	?>
</head>
<body>
	<div id='wrapper'>
		<div id='headerCon'>
			<header>
				<div id='logo'>
					<a href="<?php echo BASE_URL ?>">
						<img src='images/logo.png' title='לעמוד הבית' alt='More Gallery Logo'/>
					</a>
				</div>
				<div id='topBand_left'>
					<div id='contactDetails'>
						<a href='Contact.php'>דרך חיפה 27, קרית אתא</a>
						<a href='Contact.php'><br/>052-3766731 | 04-8725035</a>
						<br/><a href='mailto:moregllr@gmail.com' class='regularColorLink'><span class='english'>moregllr@gmail.com</span></a>
					</div>
					<nav id='topMenuCon'>
						<?php GenTopMenu(1); ?>
					</nav>
				</div>
				<div class='clear'></div>
			</header>
		</div>
		<div id='page'>	
			<div id="content">
				<?php GenContent($seoData)  ?>
			</div>
		</div>
	</div>
	<footer id='footerCon'>
		<div id='footer'>
			<div id='contactDetailsBtm'>
				נשמח לשמור איתכם על קשר:&nbsp
				<a href='Contact.php'>
					חנות: 04-8725035
					|
					שושי: 052-3766731
					|
					רותי: 050-3989909
				</a>
				|
				<a href='mailto:moregllr@gmail.com' class='regularColorLink'><span class='english'>moregllr@gmail.com</span></a>
			</div>
			<nav id='btmMenu'>
				<a id="backToTop" href="#headerCon">חזרה למעלה</a>
				|
				<a href='SiteMap.php'>מפת האתר</a>
				|
				<a href='mailto:nirsmadar@gmail.com'><span class='LinkEmphasized'>בניית אתרים</span></a>
			</nav>
			<div class='clear'></div>
		</div>
	</footer>
</body>
</html> 

<?php 
function GenTopMenu($pMenuType)
{
	if (!CanGenMenu($pMenuType)) return;
	
	$items = GetMenuItems($pMenuType, 0);
	if (is_null($items) || count($items) == 0) return;	?>
	
	<ul id="topMenu">
		<li class="topMenuItemCon">
			<div>
				<a href="<?php echo BASE_URL ?>">דף הבית</a>
			</div>
		</li>
	<?php	
	foreach ($items as $item)
	{
		$newTab = $item['IsNewTab'] == 0 ? '' : "target='_blank'";
		$subItems = GetMenuItems($pMenuType, $item['Id']);
		$areSubItems = (isset($subItems) && count($subItems) > 0 && $item['IsSubVisible'] == 1);
        $url = isset($item['Url']) ? $item['Url'] : $item['Title']   ?>
		
		<li id="topMenuItem_<?php echo $item['Order']?>" class="topMenuItemCon">
			<div>
				<a href='<?php echo $url?>' <?php echo $newTab?>>
					<?php echo $item['Title']; if ($areSubItems) echo "&#x25BE;";?>
				</a>
			</div>
	<?php
		if ($areSubItems == 1)
		{	?>
			<ul id="topMenuSub_<?php echo $item['Order']?>" class="topMenuSubCon">
			<?php
			foreach($subItems as $subItem)
			{	?>
				<li><a href=''><?php echo $subItem['Title']?></a></li>
				<?php
				if ($subItem['Order'] < count($subItems)) 
				{	?>
					<div class="topMenuSubSep">&nbsp;</div>
				<?php
				}
			}	?>
			</ul>
		<?php
		}	?>
		</li>
	<?php
	}	?>
			<li class="facebookMenuItemCon">
				<a class="facebookMenuItem" href='http://www.facebook.com/moregllr?fref=ts' target="_blank"></a>
			</li>
	
	<script type="text/javascript">
	jQuery(function() {
		jQuery("#topMenu li").hover(function() {
			jQuery(this).children(".topMenuSubCon").stop().slideToggle(300);
		});
	});
	</script>
	</ul>
	
	<?php
}

function CanGenMenu($pMenuType)
{	
	$que = "SELECT M.IsVisible
			FROM MenuType M
			WHERE Id = ".$pMenuType;
	$sql = mysql_query($que) or die('Query failure:' .mysql_error());
	list($isVisible) = mysql_fetch_row($sql);
	if ($isVisible == 0) return 0;
	else return 1;
}

function GetMenuItems($pMenuType, $pParent)
{
	$que = "SELECT M.Id, M.MenuType, M.Parent, M.Order, M.Title, M.Url, M.IsSubVisible, M.IsNewTab, M.PageId
			FROM MenuItem M
			WHERE M.MenuType =".$pMenuType." AND M.Parent = ".$pParent."  AND M.IsVisible = 1
			ORDER BY M.Order";
	$sql = mysql_query($que) or die('Query failure:' .mysql_error()); 
	$items = array();
	while ($row = mysql_fetch_assoc($sql))
	{
		$items[$row['Order']] = $row;
	}
	if (is_null($items) || count($items) == 0) return null;	
	return $items;
}
?>