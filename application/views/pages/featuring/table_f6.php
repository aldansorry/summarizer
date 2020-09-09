<table class="table table-sm table-bordered table-responsive table-y-scroll">
    <thead>
        <tr>
            <th>No</th>
            <th>Kata</th>
            <th>Formula</th>
            <th>Hasil</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data_preprocessing as $key => $value) : ?>
            <tr>
                <td><?php echo $key + 1 ?></td>
                <td><?php echo implode(",",$value) ?></td>
                <td><?php echo count($value) . " / " . $kalimat_terpanjang ?></td>
                <td><?php echo count($value) / $kalimat_terpanjang ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>