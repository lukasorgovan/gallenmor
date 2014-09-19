<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu'); ?>
    </header>

    <h1>Rasové klubovne</h1>
    <div id="hovered-race">Cigáni</div>
    <?php $this->load->view('clubhouses/_icons'); ?>

</div>

<?php
$this->load->view('layout/game/footer');
