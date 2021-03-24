<?php
require_once './functions/Twitter.php';
require_once './views/component/head.php';
require_once './views/component/header.php';
?>

<main class="container mt-4">
    <form action="./functions/recherchestats.php" method="post">
        <div class="form-group">
            <label for="recherche">Tapez votre recherche</label>
            <div class="input-group mb-3">

                <input type="text" id="recherche" name="recherche" class="form-control" placeholder="Recherche" aria-label="search">
                <input type="hidden" name="count" value="15">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</main>