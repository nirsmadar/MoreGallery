<div id='Main'>
	<div id='articlesAndMapCon'>
		<div id='articles'>
			<?php GenArticles()?>
		</div>
		<div id='mapCon'>
				<h2>
					<a href="<?php echo CONTACT_HE?>">בואו לבקר אותנו בגלריה: דרך חיפה 27, קרית אתא</a>
				</h2>
			<iframe id='map' frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.il/maps?oe=utf-8&amp;client=firefox-a&amp;q=%D7%93%D7%A8%D7%9A+%D7%97%D7%99%D7%A4%D7%94+27+%D7%A7%D7%A8%D7%99%D7%AA+%D7%90%D7%AA%D7%90&amp;ie=UTF8&amp;hq=&amp;hnear=%D7%93%D7%A8%D7%9A+%D7%97%D7%99%D7%A4%D7%94+27,+%D7%A7%D7%A8%D7%99%D7%AA+%D7%90%D7%AA%D7%90&amp;gl=il&amp;t=m&amp;z=14&amp;ll=32.805449,35.074444&amp;output=embed"></iframe>
		</div>
	</div>
	<div id='categoriesCon'>
		<?php GenFurnitureCategories(1, 4);?>
		<div style='clear:both; height:20px;'>&nbsp;</div>
		<?php GenFurnitureCategories(5, 8);?>
	</div>
	<div class='clear'></div>
	<?php GenSampleLetters();?>
</div>

<?php
$numOfArticles = 0;
function GenArticles()
{
	$maxNumOfArticles = 4;
	$que = "SELECT P.Id, P.IntOrder, P.Title, P.ShortDescription, P.PublishedDate, P.Image
			FROM Page P
			WHERE P.PageType = 1 AND P.IsVisible = 1
			ORDER BY P.PublishedDate DESC, P.IntOrder
			LIMIT ".$maxNumOfArticles."";
	$sql = mysql_query($que) or die('Query failure:' .mysql_error()); 
	while ($row = mysql_fetch_assoc($sql))
	{
		$articles[$row['Id']] = $row;
	}
	
	$numOfArticles = count($articles);
	$i = 0;
	foreach ($articles as $article) {
		$i++;
        $title = GetShortString($article['Title'], 80);
        $text = GetShortString($article['ShortDescription'], 400); ?>
		
		<article id='article_<?php echo $i?>' class='article' <?php if ($i == 1) echo 'style=display:block'?>>
			<h1><?php echo $title?></h1>
			<h4 class='articleDate'>פורסם ב-<?php echo DateTimeToDate($article['PublishedDate'])?></h4>
			<div class='articleMain'>
				<div class='articleLeft'>
					<div class='articleText'><?php echo $text?></div>
					<div class='articleBtm'>
						<a class='articleLink' href="<?php echo ARTICLES_HE."/".$article['Title'] ?>">המשך>></a>
						<div class='articleButtons'>
							<?php GenArticleButtons($i, $numOfArticles);?>
						</div>
					</div>
				</div>
				<img class='articleImg' src='upload/articles/<?php echo $article['Image']?>'/>
			</div>
		</article>
	<?php
	} ?>
	<script>
	var PrevArticleIndex = 1;
	var Timer;
	
	$(document).ready(function(){
		Timer = setInterval(SwitchArticlesOnInterval, 4000);
	});
	
	/*
	Switches articles every x seconds
	*/
	function SwitchArticlesOnInterval()
	{
		var nextArticleIndex = (PrevArticleIndex > <?php echo $numOfArticles - 1?>) ? 1 : +PrevArticleIndex + 1;
		SwitchArticles(nextArticleIndex);
	}
	
	/*
	Switches articles on every article-button click
	*/
	$(".articleButton").click(function() {
		//Freeze the timer
		clearInterval(Timer);
		//Getting the next article index
		var nextArticleIndex = this.id.substr(this.id.lastIndexOf('_') + 1);
		//Switching the articles
		SwitchArticles(nextArticleIndex);
		//Re-Setting the timer
		//Timer = setInterval(SwitchArticlesOnInterval, 4000);
	});
	
	/*
	Brings the article with index = pNextArticleIndex to the front
	*/
	function SwitchArticles(pNextArticleIndex)
	{
		$("#article_" + PrevArticleIndex).fadeOut('slow', function(){});
		$("#article_" + pNextArticleIndex).fadeIn('slow', function(){});
		PrevArticleIndex = pNextArticleIndex;
	}

    /*
    Freezes the timer when the mouse is over article
     */
    $(".article").mouseover(function() {
        clearInterval(Timer);
    });

    /*
    Unfreezes the timer when the mouse leaves article
     */
    $(".article").mouseout(function() {
        Timer = setInterval(SwitchArticlesOnInterval, 4000);
    });
	</script>
	<?php
}

function GenArticleButtons($pIndex, $pNumOfArticles)
{
	for ($i = 1; $i <= $pNumOfArticles; $i++)
	{
		if ($i == $pIndex) 
		{ ?>
			<span id='articleButton_selected'></span>
		<?php
		}
		else
		{ ?>
			<span id='articleButton_<?php echo $i?>' class='articleButton'></span>
	<?php
		}
	}
}

function GenFurnitureCategories($pFirstCategory, $pLastCategory)
{
	$categories = GetFurnitureCategories($pFirstCategory, $pLastCategory);
	
	$i = 0;
	foreach ($categories as $category) 
	{
		$i++; 
		$imagePath = "upload/furnitureCategories/".$category['Image']	?>

        <section class="categoryCon" <?php if($i == 1) echo "style='margin-right:0;'"; ?>>
            <a href="<?php echo ANTIQUE_FURNITURE_HE ?>" class="categoryLink">
                <div class="categoryTitle" style="background-color:#<?php echo $category['TitleBgColor']?>;"><?php echo $category['Title']?></div>
                <?php
                if(file_exists($imagePath))
                {   ?>
                     <img class="categoryImg" src="<?php echo $imagePath?>" title="<?php echo $category['Title']?>" alt="<?php echo $category['Title']?>" />
                <?php
                }
                else
                {
                    echo "<div class='defaultImg'>More Gallery</div>";
                }	?>
                <div class="categorySub"><?php echo $category['SubTitle']?></div>
                <div class="categoryText"><?php echo $category['Text']?></div>
            </a>
        </section>
	<?php 
	}
}
?>