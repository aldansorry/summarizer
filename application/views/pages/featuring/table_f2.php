<h5>Judul : <?php echo "[" . implode("],[", $title_preprocessing) . "]" ?></h5>
<table class="table table-sm table-bordered table-responsive table-y-scroll">
    <thead>
        <tr>
            <th>No</th>
            <th>Semua Kata</th>
            <th>Kata Sama</th>
            <th>Formula</th>
            <th>Hasil</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data_preprocessing as $key => $value) : ?>
            <tr>
                <td><?php echo $key + 1 ?></td>
                <td><?php echo "[" . implode("],[", $value) . "]" ?></td>
                <td><?php echo "[" . implode("],[", array_intersect($value, $title_preprocessing)) . "]" ?></td>
                <td><?php echo count(array_intersect($value, $title_preprocessing)) . " / " . count($title_preprocessing) ?></td>
                <td><?php echo count(array_intersect($value, $title_preprocessing)) / count($title_preprocessing) ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>