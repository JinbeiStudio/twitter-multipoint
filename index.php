<?php require_once './views/component/head.php';
require_once './views/component/header.php'; ?>

<main class="container mt-4">



    <form action="./functions/recherche.php" method="post">
        <div class="form-group">
            <label for="recherche">Tapez votre recherche</label>
            <div class="input-group mb-3">

                <input type="text" id="recherche" class="form-control" placeholder="Recherche" aria-label="search">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <?php
    if (isset($_SESSION['recherche'])) {
        require_once('./views/template/result.php');
    } else {
        echo "Pas de recherche effectuée.";
    }
    ?>

</main>


<?php require_once('./views/component/footer.php'); ?>