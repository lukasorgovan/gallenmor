<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu'); ?>
    </header>

    <h1><?= $race ?></h1>
    <?php $this->load->view('clubhouses/_icons'); ?>

</div>

<?php
$this->load->view('layout/game/footer');
