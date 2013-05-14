<div id="articlesPage" style="width:750px;">
	<?php GenArticles(); ?>
</div>

<?php
function GenArticles()
{
	$que = "SELECT P.Id, P.IntOrder, P.Title, P.ShortDescription, P.PublishedDate, P.Image
			FROM Page P
			WHERE P.PageType = ".GetPageTypeId("Article")." AND P.IsVisible = 1
			ORDER BY P.PublishedDate DESC, P.IntOrder";
			
	$sql = mysql_query($que) or die('Query failure:' .mysql_error()); 
	while ($row = mysql_fetch_assoc($sql))
	{
		$articles[$row['Id']] = $row;
	}		
		
	$numOfArticles = count($articles);
	$i = 0;
	foreach ($articles as $article)
	{
		$i++;
        $title = GetShortString($article['Title'], 100);
        $text = GetShortString($article['ShortDescription'], 300);
		$float = ($i %2 == 0) ? "left" : "right";
	
		if ($i % 2 != 0)
		{	?>
			<div <?php if ($i > 2 && (($i - 1) % 2 == 0)) echo "style='margin-top:30px;'"?>>
		<?php
		}	?>
		<article style="float:<?php echo $float.";" ?>">
			<a href="<?php echo ARTICLES_HE."/".$article['Title'] ?>">
				<img src="upload/articles/<?php echo $article['Image']?>" style="float:right;border:1px solid #aca49a;" />
				<div style="float:left;width:200px;">
					<h1><?php echo $title ?></h1>
					<h4 class='articleDate'>פורסם ב-<?php echo DateTimeToDate($article['PublishedDate'])?></h4>
					<p><?php echo $text?></p>
				</div>
				<div class="clear">&nbsp;</div>
			</a>
		</article>		
		<?php
		if (($i % 2 == 0) || (($numOfArticles % 2 != 0) && $i == $numOfArticles))
		{	?>
			<div class="clear">&nbsp;</div>
			</div>
		<?php
		}
	}
}
?>