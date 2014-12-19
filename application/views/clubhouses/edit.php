<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu'); ?>
    </header>

    <h1>Úprava klubového príspevku</h1>

    <?php if (isset($error)) { ?>
        <div class="errorMessage"><?= $error ?></div>
        <?php
    } else {
        ?>
        <form action="<?= site_url('clubhouses/updatePost') ?>" method="POST" id="edit_post_form">
            <textarea name="message" cols="50" rows="10"><?= $post['message'] ?></textarea>
            <input type="hidden" name="codename" value="<?= $post['codename'] ?>" />
            <input type="hidden" name="id" value="<?= $post['id'] ?>" />
            <input type="submit" value="Upraviť" />
        </form>
        <?php
    }
    ?>
</div>

<?php
$this->load->view('layout/game/footer');
