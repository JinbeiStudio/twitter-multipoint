<p>Result</p>

<!-- <? echo('<pre>');
print_r($tweets);//[0]->display();
echo('</pre>');
?> -->


<?php
foreach (unserialize($_SESSION['recherche']) as $tweet) {
    // echo 'test';
    echo $tweet->display();
} ?>