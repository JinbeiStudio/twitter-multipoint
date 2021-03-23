<?php 
    require_once './views/component/head.php';
    require_once './views/component/header.php'; 
?>

<form action="./functions/recherche.php" method="post">
    <div class="input-group">
        <div class="form-outline">
            <input required name="recherche" type="search" id="recherche" class="form-control" />
            <label class="form-label" for="form1">Rechercher</label>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>

<?php
<<<<<<< HEAD
    $view = './views/template/no_search.php';
    if (isset($_SESSION['recherche'])) {
        $view = './views/template/result.php';
    } 
    require_once $view;
    require_once('./views/component/footer.php'); 
?>
=======
$view = './views/template/start.php';
if (isset($_SESSION['recherche'])) {
    $view = './views/template/result.php';
}
require_once $view;

?>
<?php require_once('./views/component/footer.php'); ?>
>>>>>>> 2a7a132bc7c5aed3c89b4930c6dc887006697a1b
