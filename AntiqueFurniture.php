<div id="antiqueFurniture">
	<!--
	##################################
		-	BACKGROUND MODULE	-
	##################################

		- bg-fit-outside or
		- bg-fit-inside or
		- bg-stretch
		- bg-tiled

		and

		- fadein
	###################################

	<div id="main-background">
		<div class="bg-fit-outside fadein" data-category="catall" data-src="images/bg/light_bg1.jpg"></div>
		<div class="bg-fit-outside fadein" data-category="cata" data-src="images/bg/light_bg2.jpg"></div>
		<div class="bg-fit-outside fadein" data-category="catb"  data-src="images/bg/light_bg3.jpg"></div>
		<div class="bg-fit-outside fadein" data-category="catc"  data-src="images/bg/light_bg4.jpg"></div>
	</div>
	-->
	
	<div id="content_wrap" style="z-index:100">
		<!--
		##############################
		 - CONTENT & EXAMPLES -
		##############################
		-->
		<div style="width:920px;margin:auto;position:relative;">
			<!-- THE FILTER BUTTON -->
			<div id="portfolio-filter" class="filter dropdown">
				<div class="buttonlight"><span class="category">סינון לפי קטגוריה</span></div>
				<ul>
					<?php GenFurnitureCategories();	?>
				</ul>
			</div>
			<!-- THE SELECTED FILTER -->
			<div>
				<h2 style="float:right;margin-right:200px;">הקטגוריה שנבחרה:&nbsp;</h2>
				<h2><div id="selected-filter-title" style="text-decoration:underline">כל הרהיטים</div></h2>
			</div>
		</div>
		<div class="example-wrapper">
			<!-- THE PORTFOLIO GRID ITSELF -->
			<div id="products" class="tp-portfolio">
				<?php GenFurnitures();	?>
			</div>
		</div>	<!-- EXAMPLE WRAP END -->
	</div>	<!-- CONTENT WRAP END -->
	<!--
	##############################
	 - ACTIVATE THE BANNER HERE -
	##############################
	-->
	<script type="text/javascript">

		var tpj=jQuery;
		tpj.noConflict();

		tpj(document).ready(function() {

		if (tpj.fn.cssOriginal!=undefined)
			tpj.fn.css = tpj.fn.cssOriginal;

			tpj('#products').portfolio({
				<!-- GRID SETTINGS -->
				gridOffset:30,				<!-- Manual Right Padding Offset for 100% Width -->
				cellWidth:176,						<!-- The Width of one CELL in PX-->
				cellHeight:176,						<!-- The Height of one CELL in PX-->
				cellPadding:10,						<!-- Spaces Between the CELLS -->
				entryProPage:12,						<!-- The Max. Amount of the Entries per Page, Rest made by Pagination -->

				<!-- CAPTION SETTING -->
				captionOpacity:85,

				<!-- FILTERING -->
				filterList:"#portfolio-filter",		<!-- Which Filter is used for the Filtering / Pagination -->
				title:"#selected-filter-title",		<!-- Which Div should be used for showing the Selected Title of the Filter -->
				<!-- Page x from All Pages -->
				pageOfFormat:"עמוד #n מתוך #m",		<!-- The #n will be replaced with the actual Item Nr., #m will be replaced with the amount of all items in the filtered Gallery-->
				<!-- Social Settings-->
				showGoogle:"no",					<!-- Show The Social Buttons ...-->
				showFB:"no",
				showTwitter:"no",
				urlDivider:"?",						<!-- What is the Divider in the Url to add the Variables, Filter and Image ID . Impotant for WordPress i.e. Social will share this link with this divider -->

				showEmail:"no",							<!-- ADD EMAIL TO LINK ALSO TO THE LIGHTBOX  -->
				emailLinkText:"Email to Friend",
				emailBody:"mailto:email@echoecho.com?body=I found some great File here #url",	<!-- The #url will be replaced with the url of the image -->
				emailUrlCustomPrefix:"http://www.themepunch.com/",								<!-- Use this if you wish a Custom Prefix to Link Path -->
				emailUrlCustomSuffix:"?ref=...",												<!-- Use This if you wish to use a Custtom Suffix for Link Path -->


				<!-- BACKGROUND -->
				backgroundHolder:"#main-background",
				backgroundSlideshow:0
			})
	});
	</script>
</div>

<?php
function GenFurnitureCategories()
{	?>
	<li data-category="catall">כל הרהיטים</li>
	<li><div class="topMenuSubSep">&nbsp;</div></li>
	
	<?php
	$categories = GetFurnitureCategories();
	$i = 0;
	foreach ($categories as $category) 
	{
		$i++;	?>
		
		<li data-category="cat-<?php echo $category['Id'] ?>"><?php echo $category['Title'] ?></li>
		<?php 
		if ($i != count($categories))
		{	?>
			<li><div class="topMenuSubSep">&nbsp;</div></li>
		<?php
		}
	}
}

function GenFurnitures()
{
		$que = "SELECT *
				FROM Furniture F
				WHERE  F.IsVisible = 1
				ORDER BY F.Order";
			
	$sql = mysql_query($que) or die('Query failure:' .mysql_error()); 
	while ($row = mysql_fetch_assoc($sql))
	{
		$furnitures[$row['Order']] = $row;
	}

	foreach ($furnitures as $furniture)
	{
        $isUrl = isset($furniture['Url'])
		?>
		
		<div class="cell<?php echo $furniture['ThumbWidthFactor']?>x<?php echo $furniture['ThumbHeightFactor']?> <?php echo "cat-".$furniture['CategoryId']?> catall">
			<div class="thumbnails" data-mainthumb="upload/furnitures/<?php echo $furniture['ThumbPath']?>" data-bwthumb="upload/furnitures/<?php echo $furniture['FadedThumbPath']?>"></div>
			<div class="caption"><?php echo $furniture['Title']?></div>
            <?php
            if ($isUrl)
            {   ?>
                <a href="<?php echo $furniture['Url']?>" class="blog-link"></a>
            <?php
            }
            ?>
			<div class="entry-info">
				<div class="media" data-src="upload/furnitures/<?php echo $furniture['ImagePath']?>"></div>
				<div class="entry-title"><?php echo $furniture['Title']?></div>
				<div class="entry-description"><?php echo $furniture['Description']?></div>
				<?php 
				if ($furniture['IsSold'] == 1)
				{	?>
					<div class="entry-sold">הפריט נמכר</div>
				<?php
				}	?>
			</div>
		</div>
		
		<?php
	}
}



