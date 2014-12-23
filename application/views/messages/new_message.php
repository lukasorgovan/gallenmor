<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu'); ?>
    </header>

    <?php $this->load->view('messages/_menu'); ?>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="successMessage"><?= $this->session->flashdata('success') ?></div>
    <?php endif ?>

    <?php if ($this->session->flashdata('error')) : ?>
        <div class="errorMessage"><?= $this->session->flashdata('error') ?></div>
    <?php endif ?>

    <h2>Vytvoriť novú správu</h2>
    <?php
    $data['bird_available'] = $bird_available;
    $data['curtime'] = $curtime;
    $this->load->view('messages/_type_selector', $data);
    $this->load->view('messages/_form', $data);
    ?>
</div>

<?php $this->load->view('layout/game/footer'); ?>