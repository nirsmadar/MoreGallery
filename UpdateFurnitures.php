<div>
    <?php GetFurnitures();?>
</div>

<?php
function GetFurnitures()
{
    $que = "SELECT F.Id, F.Url, F.ThumbWidthFactor, F.ThumbHeightFactor, F.CategoryId, F.ThumbPath, F.FadedThumbPath,
                       F.Title, F.Description, F.IsSold, F.IntOrder as FurnitureOrder, C.IntOrder as CategoryOrder,
                       F.ImagePath, F.CategoryId, C.Name as CategoryName, C.Title as CategoryTitle
				FROM Furniture F INNER JOIN FurnitureCategory C ON (F.CategoryId = C.Id)
				WHERE  F.IsVisible = 1
				ORDER BY C.IntOrder ASC, F.IntOrder DESC";

    $sql = mysql_query($que) or die('Query failure:' .mysql_error());
    $r = 0;
    while ($row = mysql_fetch_assoc($sql))
    {
        $furnitures[$row['Id']] = $row;
    }

    foreach ($furnitures as $furniture)
    {   ?>
        <div>
            <img src="upload/furnitures/<?php echo $furniture['CategoryName']."/".$furniture['ImagePath']?>" width="300" height="200" style="float:right;margin-left:20px ">
            <div>
                קוד:
                <input type="text"/>
                כותרת:
                <input type="text" class="input2"/>
                <br/>
                <br/>
                תיאור:
                <textarea style="width:530px;height:100px"></textarea>
                <br/>
                <br/>
                פקטור רוחב:
                <select>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
                פקטור גובה:
                <select>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
                נמכר:
                <select>
                    <option value="0">לא</option>
                    <option value="1">כן</option>
                </select>
            </div>
            <div class="clear"></div>
        </div>
        <br/>
    <?php
    }
}
