<p>
    <?php $paragraft = 0 ?>
    <?php foreach ($summarized_kalimat as $key => $value) : ?>

        <?php echo $value->kalimat . "."; ?>
        <?php if ($paragraft != $value->paragraft) : ?>
</p>
<p>
    <?php $paragraft = $value->paragraft ?>
<?php endif ?>
<?php endforeach ?>
</p>