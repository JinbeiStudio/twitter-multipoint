<p>Result</p>
<?php include_once('./cinema.php');?>

<? $tweets = $tweet->getResult(); ?>



<!-- <? echo('<pre>');
print_r($tweets);//[0]->display();
echo('</pre>');
?> -->


<?php foreach ($tweets as $tweet) {
    // echo 'test';
    echo $tweet->display();
 } ?>

