<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu') ?>
    </header>

    <?php if ($this->session->flashdata('error')) : ?>
        <div class="errorMessage"><?= $this->session->flashdata('error') ?></div>
    <?php endif ?>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="successMessage"><?= $this->session->flashdata('success') ?></div>
    <?php endif ?>

    <form action="<?= site_url('profile/edit') ?>" method="POST" id="accout_edit">
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?php echo $this->session->userdata('email') ?>"/>
        <label for="old_password">Staré heslo:</label>
        <input type="text" name="old_password" id="old_password"/>
        <label for="new_password">Nové heslo:</label>
        <input type="text" name="new_password" id="new_password"/>
        <label for="new_password_copy">Zopakuj nové heslo:</label>
        <input type="text" name="new_password_copy" id="new_password_copy"/>
        <input type="hidden" name="edit_accout" value="1" />
        <input type="submit" value="Upraviť" />
    </form>

</div>

<?php $this->load->view('layout/game/footer'); ?>