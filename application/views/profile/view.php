<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu') ?>
    </header>

    <?= anchor('profile/edit', 'Upraviť nastavenia účtu'); ?><br>
    <?= anchor('profile/avatar', 'Upraviť avatar účtu'); ?>

    <br><br>
    <h1>Vitaj <?= $this->session->userdata('username') ?></h1>

    <p>Tvoje postavy:</p>
    <?php
    if (count($characters) == 0) {
        echo "Na tvojom účte nie sú žiadne postavy";
    }
    foreach ($characters as $char) {
        echo "<strong>" . $char['charname'] . '</strong><br/>';
        echo "Rasa: " . $char['race'] . '<br/>';
        echo "Vek: " . $char['age'] . '<br/>';
        echo '<br/>';
    }
    ?>
    <?= anchor('profile/editCharacters', 'Spravovať postavy'); ?>
</div>


<?php $this->load->view('layout/game/footer'); ?>