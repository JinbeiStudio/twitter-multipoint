<?php $tweets = unserialize($_SESSION['recherche']); ?>

<p class="text-right">
    <?php
    //Affichage du nb de twweets trouvés ou message en cas de résultat nul
    echo count($tweets) ? count($tweets) . ' Résultats' :  'Aucun résultat n\'as été trouvé. Elargissez votre recherche.';
    ?>
</p>
</div>

<section class="d-flex flex-wrap justify-content-center mb-3">
    <?php foreach ($tweets as $tweet) {
        /* echo '<pre>';
        print_r($tweet);
        echo '</pre>'; */
    }
    ?>


    <?php
    //Boucle d'affichage des cartes de tweets
    foreach ($tweets as $tweet) {


        // Formattage des variables pour l'affichage et Chargement des images
        $tweet->display();
    ?>

        <div class="card m-2 twitter-card">
            <?php
            if ($tweet->user["profile_banner_temp"]) {
            ?>
                <div class="card-img-top-perso" style="background-image: url(<?php echo $tweet->user["profile_banner_temp"]; ?>);">
                </div><!-- .card-img-top-perso -->
            <?php
            }
            ?>

            <div class='card-body'>
                <div class="userPicture">
                    <img src="<?php echo $tweet->user["profile_image_temp"]; ?>" class="rounded-circle mx-auto d-block shadow-sm" width="48" height="48" />
                </div>
                <h5 class='card-title'><?php echo $tweet->name; ?></h5>
                <time><?php echo $tweet->created_at; ?></time>
                <p class='card-text'><?php echo $tweet->text; ?></p>
                <!-- Citation -->
                <?php if ($tweet->quote) { ?>
                    <div class="border border-secondary rounded p-2">
                        <strong><?php echo $tweet->quote_user; ?>&nbsp;:</strong> <br />
                        <?php echo $tweet->quote_text; ?>
                    </div>
                <?php } ?>

                <?php if ($tweet->RT_quote) { ?>
                    <div class="border border-secondary rounded p-2">
                        <strong><?php echo $tweet->RT_quote_user; ?>&nbsp;:</strong> <br />
                        <?php echo $tweet->RT_quote_text;
                        ?>
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