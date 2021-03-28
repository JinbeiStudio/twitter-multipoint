<?php $tweets = unserialize($_SESSION['recherche']); ?>

<p class="text-right">
    <?php
    //Affichage du nb de twweets trouvés ou message en cas de résultat nul
    echo count($tweets) ? count($tweets) . ' Résultats' :  'Aucun résultat n\'as été trouvé. Elargissez votre recherche.';
    ?>
</p>
</div>

<section class="d-flex flex-wrap justify-content-center mb-3">

    <?php
    //Boucle d'affichage des cartes de tweets
    foreach ($tweets as $tweet) {
        /* echo '<pre>';
        print_r($tweet);
        echo '</pre>';
        exit(); */

        // Formattage des variables pour l'affichage et Chargement des images
        $tweet->display();
    ?>

        <div class="card m-2 twitter-card">
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
                <!-- Citation -->
                <?php if ($tweet->quote) { ?>
                    <div class="border border-secondary rounded p-2">
                        <?php echo $tweet->quote_user; ?>&nbsp;: <br />
                        <?php echo $tweet->quote_text; ?>
                    </div>
                <?php } ?>
            </div><!-- .card-body -->

            <div class="card-footer d-flex flex-row">
                <span class="mdi mdi-heart-outline"><?php echo $tweet->favorite_count; ?></span>
                <span class="mdi mdi-repeat mdi-rotate-90"><?php echo $tweet->retweet_count; ?></span>
                <a href="<?php echo $tweet->url; ?>" target="_blank" class="ml-auto mdi mdi-open-in-new">Twitter</a>
            </div>
            <!-- .card-footer -->
        </div><!-- .card -->

    <?php
    }
    ?>

</section>