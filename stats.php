<?php
require_once './functions/Twitter.php';
require_once './views/component/head.php';
require_once './views/component/header.php';
$tweets = unserialize($_SESSION['recherche']);
?>

<main class="container mt-4">
    <h2 class="my-4">Statistiques d'intérêt par langue</h2>
    <form action="./functions/recherche.php" method="post">
        <div class="form-group">
            <label for="recherche">Tapez votre recherche</label>
            <div class="input-group mb-3">

                <input type="text" id="recherche" name="recherche" class="form-control" placeholder="Recherche" aria-label="search">
                <input type="hidden" name="count" value="15">
                <input type="hidden" name="page" value="stats">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="d-flex justify-content-between">
        <p class="text-primary"><?php echo (isset($_SESSION['terme'])) ? 'Résultats pour : ' . $_SESSION['terme'] : '' ?></p>
        <p> <?php if (isset($_SESSION['recherche'])) {
                echo count($tweets) . " Résultats";
            } else {
                echo "<span class='font-weight-bold'>Pas de recherche effectuée</span>";
            }; ?></p>
    </div>
    <?php if (isset($_SESSION['stats'])) { ?>
        <table id="statsTable" class="table table-striped">
            <thead>
                <th>Langue</th>
                <th>Proportion</th>
            </thead>
            <tbody>
                <?php foreach (unserialize($_SESSION['stats']) as $key => $value) { ?>
                    <tr>
                        <td><?php echo $key ?></td>
                        <td><?php echo round($value / count($tweets) * 100, 2) . " %" ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        foreach (unserialize($_SESSION["stats"]) as $key => $value) {
            $labels[] = $key;
            $datasets[] = round($value / count($tweets) * 100, 2);
        }
        $labels = json_encode($labels);
        $datasets = json_encode($datasets);
        ?>
        <div class="row mt-5 mb-5">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
</main>
<?php
require_once './views/component/footer.php';
?>
<script>
    $(document).ready(function() {
        $('#statsTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['excel', 'pdf', 'print'],
            language: {
                url: 'traductions/french.json'
            }
        });
    });

    let labels = <?php echo $labels ?>;
    let datasets = <?php echo $datasets ?>;

    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                data: datasets
            }],
            labels: labels
        },
        options: {
            plugins: {
                colorschemes: {
                    scheme: 'office.BlueWarm6'
                }
            }
        }
    });
</script>