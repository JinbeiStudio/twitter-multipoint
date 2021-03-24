<!--p>Result</p-->

<pre>
<?php
// print_r(unserialize($_SESSION['recherche']));
?>
</pre>


<section class="d-flex flex-wrap justify-content-center">

    <?php
    foreach (unserialize($_SESSION['recherche']) as $tweet) {
        // formattage des variables
        $date = new DateTime($tweet->created_at);
        $created_at = $date->format('Y-m-d H:i:s');

        $userName = $tweet->user["name"];

        $text = $tweet->text;

        //Chargement des images
        $tweet->loadImages();
        $userPicture = $tweet->user["profile_image_temp"];
        $userBackground = $tweet->user["profile_banner_temp"];
    ?>

        <div class='card m-2' style='width: 18rem;'>
            <?php if ($userBackground) { ?>
                <img src="<?php echo $userBackground; ?>" class="card-img-top" style="margin-bottom: -44px;">
            <?php } ?>
            <div class='card-body'>
                <div class="userPicture"><img src="<?php echo $userPicture; ?>" class="rounded-circle mx-auto d-block shadow-sm" width="48" height="48" /></div>
                <h5 class='card-title'><?php echo $userName; ?></h5>
                <h6><?php echo $created_at; ?></h6>
                <p class='card-text'><?php echo $text; ?></p>
            </div><!-- .card-body -->
        </div><!-- .card -->

    <?php
    }
    ?>

</section>