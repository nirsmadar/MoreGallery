<div id="lettersPage">
	<?php GenLetters(); ?>
</div>

<script>
    var hash = window.location.hash.substring(1);
    $("#" + hash).css("display", "none");
    $("#" + hash).fadeIn(5000);
</script>