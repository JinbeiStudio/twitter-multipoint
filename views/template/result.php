<?php $tweets = unserialize($_SESSION['recherche']); ?>

<p class="text-right">
    <?php
    //Affichage du nb de twweets trouvés ou message en cas de résultat nul
    echo count($tweets) ? count($tweets) . ' Résultats' :  'Aucun résultat n\'as été trouvé. Elargissez votre recherche.';
    ?>
</p>
</div>


<section class="d-flex flex-wrap justify-content-center">

    <?php
    //Boucle d'affichage des cartes de tweets
    foreach ($tweets as $tweet) {

        // Formattage des variables pour l'affichage et Chargement des images
        $tweet->display();
    ?>

        <div class='card m-2' style='width: 18rem;'>
            <?php
            if ($tweet->user["profile_banner_temp"]) {
            ?>
                <img src="<?php echo $tweet->user["profile_banner_temp"]; ?>" class="card-img-top" style="margin-bottom: -44px;">
            <?php
            }
            ?>
            <div class='card-body'>
                <div class="userPicture">
                    <img src="<?php echo $tweet->user["profile_image_temp"]; ?>" class="rounded-circle mx-auto d-block shadow-sm" width="48" height="48" />
                </div>
                <h5 class='card-title'><?php echo $tweet->name; ?></h5>
                <h6><?php echo $tweet->created_at; ?></h6>
                <p class='card-text'><?php echo $tweet->text; ?></p>
            </div><!-- .card-body -->
        </div><!-- .card -->

    <?php
    }
    ?>

</section>