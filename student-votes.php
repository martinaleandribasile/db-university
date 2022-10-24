<div class="py-5 w-80 d-flex align-items-center gap-5 flex-column">
    <?= '<div class="text-primary">ESAME:  </div>' . $row['esame'] ?>
    <div class="d-flex justify-content-center gap-5">
        <div class="">
            <?= $row['name'] ?>
        </div>
        <div class="">
            <?= $row['surname'] ?>
        </div>
        <div class="">
            <?= $row['voto'] ?>
        </div>
        <div class="<?= $row['stato_esame'] == 'PROMOSSO' ? 'text-success' : 'text-danger' ?>">
            <?= $row['stato_esame'] ?>
        </div>
    </div>
</div>