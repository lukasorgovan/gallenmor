<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu'); ?>
    </header>

    <h1>Sekcia <?php echo $section; ?></h1>
    <?php echo anchor('items', 'Späť do obchodu'); ?><br>

    <?php
    if (empty($items)) {
        echo 'V sekcii nie sú žiadne predmety';
    }

    foreach ($items as $item) {
        $this->load->view('items/_item', $item);
    }
    ?>
</div>

<?php
$this->load->view('layout/game/footer');


