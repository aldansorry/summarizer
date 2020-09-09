<table class="table table-sm table-bordered table-responsive table-y-scroll">
    <thead>
        <tr>
            <?php foreach($column as $key => $value): ?>
                <th><?php echo $value['title'] ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $key => $value): ?>
            <tr>
                <?php foreach($value as $k => $v): ?>
                    <td><?php echo $v ?></td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>