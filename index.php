<?php echo ("Twitter multipoint");

include_once("header.php")
?>

<form action="recherche.php" method="post">
    <div class="input-group">
        <div class="form-outline">
            <input name="recherche" type="search" id="form1" class="form-control" />
            <label class="form-label" for="form1">Rechercher</label>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>

<?php

include_once("footer.php")
?>