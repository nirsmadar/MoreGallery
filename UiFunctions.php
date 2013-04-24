<?php
function GenSampleLetters() 
{
	$que = "SELECT L.Id, L.Order, L.Title, L.Text
			FROM Letter L
			WHERE  L.IsVisible = 1
			ORDER BY L.Order
			LIMIT 3";
	
	$sql = mysql_query($que) or die('Query failure:' .mysql_error()); 
	while ($row = mysql_fetch_assoc($sql))
	{
		$letters[$row['Order']] = $row;
	}	?>
	
	<div id="sampleLettersCon">
	<?php
	$i = 0;
	$flowersIndex = 0;
	foreach ($letters as $letter) 
	{
		$i++;
		if ($i >= 5) $flowersIndex = 1;
		else $flowersIndex++;
		$text = GetShortString($letter['Text'], 100) ?>
		
		<section class='letterCon' <?php if ($i == 1) echo "style='margin-right:0;'"?>>
			<div class='letter'>
				<h3 class='letterTitle'><?php echo $letter['Title']?></h3>
				<p class='letterText'><?php echo $text?></p>
				<div class='letterBtm'>
					<a class='lettersLink' href='letters.php'>המשך>></a>
					<img class='letterImg' src='images/letters/<?php echo $flowersIndex?>.png'/>
					<div class='clear'></div>
				</div>
			</div>
		</section>
	<?php 
	}	?>
		
        <div id='addLetterCon' onclick="ShowDialog()">
            <div id='addLetter'>
                <p>
                ביקרתם בחנות?
                <br/>נהנים לגלוש באתר?
                </p>
                <h2 class='letterTitle'>לחצו להוספת מכתב אישי!</h2>
            </div>
        </div>

        <div id="dialogCon">
            <div id="addLetterForm" class="dialog">
                <div onclick=CloseDialog() id="closeButton"></div>
                <h2>כתבו לנו</h2>
                <div class="">
                    <div style="float:right;">
                        <div>שם</div>
                        <input class="input2" type="text"/>
                    </div>
                    <div class="clear">&nbsp;</div>

                    <div class="formElementCon">כתובת מייל</div>
                    <input type="text" class="input2" style="text-align:left"/>

                    <div class="formElementCon">כותרת</div>
                    <input type="text" class="input2"/>

                    <div class="formElementCon">תוכן ההודעה</div>
                    <textarea class="input2" style="height:150px"></textarea>

                    <div class="formElementCon">
                        <input type="submit" value="שליחה"/>
                    </div>
                    <div class="clear">&nbsp;</div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function CloseDialog()
            {
                $("#dialogCon").cssFadeOut(500, function()
                {
                    this.css("display", "none");
                });
            }
            function ShowDialog()
            {
                $("#dialogCon").cssFadeIn(500, function()
                {
                    this.css("display", "block");
                });
            }
        </script>
	</div>
<?php
}

function GenLetters()
{
	$que = "SELECT L.Id, L.Order, L.Title, L.Text
			FROM Letter L
			WHERE  L.IsVisible = 1
			ORDER BY L.Order";
	
	$sql = mysql_query($que) or die('Query failure:' .mysql_error()); 
	while ($row = mysql_fetch_assoc($sql))
	{
		$letters[$row['Order']] = $row;
	}	?>
	
	<div id="lettersCon">
	<?php
	$i = 0;
	$flowersIndex = 0;
	foreach ($letters as $letter) 
	{
		$i++;
		if ($i >= 5) $flowersIndex = 1;
		else $flowersIndex++;	?>
		
		<section class='letterCon' <?php if ($i == 1 || (($i - 1) % 4 == 0)) echo "style='margin-right:0;'"?>>
			<div class='letter'>
				<h3 class='letterTitle'><?php echo $letter['Title']?></h3>
				<p class='letterText'><?php echo $letter['Text']?></p>
				<div class='letterBtm'>
					<a class='lettersLink' href='letters.php'><?php echo $i?></a>
					<img class='letterImg' src='images/letters/<?php echo $flowersIndex?>.png'/>
					<div class='clear'></div>
				</div>
			</div>
		</section>
<?php
	}	?>
	</div>
<?php
}

function GenPagination()
{
	$NUM_OF_RECORDS_PER_PAGE = 6;
	$numOfRecords = 103;
	$numOfPages = ceil($numOfRecords / $NUM_OF_RECORDS_PER_PAGE);
	?>
	
	<ul id="paginationCon">
		<li><a style="margin-right:0;" href="">|<</a></li>
		<li><a href="" style="width:80px;">< הקודם</a></li>
		
		<li>
			<div style="border:1px solid #c9c5bc;height:20px;margin-right:5px;padding:5px;position:relative">
				<span>דף </span>
				<form style="display:inline;">
					<input type="text" value="1" style="width:30px;font-size:18px;text-align:center;padding:0;position:absolute"/>
				</form>
				<span>מתוך <?php echo $numOfPages?></span>
			</div>
		</li>
		
		<li><a href="" style="width:80px;">הבא ></a></li>
		<li><a href="">>|</a></li>
	</ul>
	<div class="clear">&nbsp;</div>
	<?php
	
}
?>

















