<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu') ?>
    </header>

    <?= anchor('profile/edit', 'Upraviť nastavenia účtu'); ?>

   <br><br>
   <h1>Vitaj <?= $this->session->userdata('username') ?>
    Load all information from database, populate javascript framework, Behave as single app.
</div>

<?php $this->load->view('layout/game/footer'); ?>