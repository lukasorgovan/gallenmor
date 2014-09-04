<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu') ?>
    </header>

    <?php echo validation_errors(); ?>
    <?php if ($this->session->flashdata('success')) : ?>
        <div class="successMessage"><?= $this->session->flashdata('success') ?></div>
    <?php endif ?>


    <form action="<?= site_url('profile/edit') ?>" method="POST" id="accout_edit">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo set_value('email', $this->session->userdata('email')) ?>"/>
        <label for="old_password">Staré heslo:</label>
        <input type="password" name="old_password" id="old_password" value="<?php echo set_value('old_password'); ?>"/>
        <label for="new_password">Nové heslo:</label>
        <input type="password" name="new_password" id="new_password" value="<?php echo set_value('new_password'); ?>"/>
        <label for="new_password_copy">Zopakuj nové heslo:</label>
        <input type="password" name="new_password_copy" id="new_password_copy" value="<?php echo set_value('new_password_copy'); ?>"/>
        <input type="hidden" name="edit_accout" value="1" />
        <input type="submit" value="Upraviť" />
    </form>

</div>

<?php $this->load->view('layout/game/footer'); ?>