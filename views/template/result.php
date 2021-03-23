<!--p>Result</p-->

<pre>
<?php
// print_r(unserialize($_SESSION['recherche'])); 
?>
</pre>


<section class="row">

    <?php
    foreach (unserialize($_SESSION['recherche']) as $tweet) {
        // formattage des variables
        $date = new DateTime($tweet->created_at);
        $created_at = $date->format('Y-m-d H:i:s');

        $userName = $tweet->user["name"];
        $userPicture = $tweet->user["profile_image_url"];
        $text = $tweet->text;

    ?>



        <div class='card' style='width: 18rem;'>
            <div class='card-body'>
                <div class="userPicture"><img src="<?php echo $userPicture; ?>" /></div>
                <h5 class='card-title'><?php echo $userName; ?></h5>
                <h6><?php echo $created_at; ?></h6>
                <p class='card-text'><?php echo $text; ?></p>
            </div><!-- .card-body -->
        </div><!-- .card -->

    <?php
    }
    ?>

</section>