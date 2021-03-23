<!--p>Result</p-->

<?php

/*echo '<pre>';
print_r(unserialize($_SESSION['recherche']));
echo '</pre>';*/

foreach (unserialize($_SESSION['recherche']) as $tweet) {
    // echo 'test';
    echo $tweet->display();
} ?>