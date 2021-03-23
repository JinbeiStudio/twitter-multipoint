<?php require_once './views/component/head.php';
require_once './views/component/header.php'; ?>

<form action="./functions/recherche.php" method="post">
    <div class="input-group">
        <div class="form-outline">
            <input name="recherche" type="search" id="recherche" class="form-control" />
            <label class="form-label" for="form1">Rechercher</label>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>

<?php
if (isset($_SESSION['recherche'])) {
    require_once('./views/template/result.php');
} else {
    echo "Pas de recherche effectuée.";
}

?>
<?php require_once('./views/component/footer.php'); ?>