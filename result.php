<p>Result</p>
<?php include_once('./cinema.php'); ?>

<?php // var_dump($resultTwitter); 

$tweets = $resultTwitter->statuses; ?>



<?php foreach ($tweets as $key => $value) { ?>

<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title"><?php echo $value->user->name;  ?></h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>

<?php } ?>

</ul>
