<div id="articlesPage" style="width:750px;">
	<?php GenArticles();	?>
</div>

<?php
function GenArticles()
{
	$que = "SELECT A.Id, A.Order, A.Title, A.ShortDescription, A.IsVisible, A.PublishedDate, A.Image
			FROM Article A
			ORDER BY A.PublishedDate DESC, A.Order";
			
	$sql = mysql_query($que) or die('Query failure:' .mysql_error()); 
	while ($row = mysql_fetch_assoc($sql))
	{
		$articles[$row['Order']] = $row;
	}		
		
	$numOfArticles = count($articles);
	$i = 0;
	foreach ($articles as $article)
	{	
		if ($article['IsVisible'] == 0) continue; 
		$i++;
        $title = GetShortString($article['Title'], 36);
        $text = GetShortString($article['ShortDescription'], 160);
		$float = ($i %2 == 0) ? "left" : "right";
	
		if ($i % 2 != 0)
		{	?>
			<div <?php if ($i > 2 && (($i - 1) % 2 == 0)) echo "style='margin-top:30px;'"?>>
		<?php
		}	?>
		<article style="border-bottom:1px solid #cccccc;width:340px;height:210px;float:<?php echo $float.";" ?>">
			<a href="" >
				<img src="images/articles/<?php echo $article['Image']?>" style="float:right;" />
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