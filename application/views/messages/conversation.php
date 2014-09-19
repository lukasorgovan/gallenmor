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

    <?php if (isset($error)) : ?>
        <div class="errorMessage"><?= $error ?></div>
        <?php
        return;
    endif;
    ?>  

    <h2>Konverzácia s <?php echo $username ?></h2>
    <?php $this->load->view('messages/_form'); ?>

    <?php
    foreach ($messages as $msg) {
        $this->load->view('messages/_message', $msg);
    }
    ?>
</div>

<?php $this->load->view('layout/game/footer'); ?>