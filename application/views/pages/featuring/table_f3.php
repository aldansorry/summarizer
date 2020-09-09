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
                <td>
                    <?php
                    $string = "[";
                    $count_capital = 0;
                    foreach ($value as $k => $v) {
                        if (preg_match('/[A-Z]/', $v)) {
                            $string .= "<b>".$v . "</b>],[";
                            $count_capital++;
                        } else {
                            $string .= $v . "],[";
                        }
                    }
                    $string = substr($string, 0, -1);
                    echo $string;
                    ?>
                </td>
                <td><?php echo $count_capital . " / " . count($value) ?></td>
                <td><?php echo $count_capital / count($value) ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>