<?php
require_once './functions/Twitter.php';
require_once './views/component/head.php';
require_once './views/component/header.php';
?>

<main class="container mt-4">
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
    <?php if (isset($_SESSION['stats'])) { ?>
        <table id="statsTable" class="table table-striped">
            <thead>
                <th>Code Pays</th>
                <th>Nombre</th>
            </thead>
            <tbody>
                <?php foreach (unserialize($_SESSION['stats']) as $key => $value) { ?>
                    <tr>
                        <td><?php echo $key ?></td>
                        <td><?php echo $value ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        foreach (unserialize($_SESSION["stats"]) as $key => $value) {
            $labels[] = $key;
            $datasets[] = $value;
        }
        $labels = json_encode($labels);
        $datasets = json_encode($datasets);
        ?>
        <canvas id="myChart" width="400" height="400"></canvas>
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
        }
    });
</script>