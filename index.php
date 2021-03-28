<?php
require_once './functions/Twitter.php';
require_once './views/component/head.php';
require_once './views/component/header.php';
?>
<main class="container mt-4">

    <form action="./functions/recherche.php" method="post">
        <div class="form-group">
            <label for="recherche">Tapez votre recherche</label>
            <div class="input-group mb-3">

                <input type="text" id="recherche" name="recherche" class="form-control" placeholder="Recherche" aria-label="search">
                <input type="hidden" name="count" value="15">
                <input type="hidden" name="page" value="index">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <p class="text-primary">
        <?php
        $tweets = unserialize($_SESSION['recherche']);
        if (isset($_SESSION['terme'])) {
            echo count($tweets) ? count($tweets) . ' Résultats pour "' . $_SESSION['terme'] . '" :' :  'Aucun résultat n\'as été trouvé. Elargissez votre recherche.';
        }
        ?></p>

    <?php

    //Affiche le result si une recherche est présente sinon affiche no_search 
    require_once  $_SESSION['recherche'] ? './views/template/result.php' : './views/template/no_search.php';
    ?>

</main>

<?php
require_once './views/component/footer.php';
?>