<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu'); ?>
    </header>

    <h1>Rasové klubovne</h1>
    <div id="hovered-race">Cigáni</div>
    <?php
    $data['races'] = $user_races;
    $this->load->view('clubhouses/_icons', $data);
    ?>

</div>

<?php
$this->load->view('layout/game/footer');
