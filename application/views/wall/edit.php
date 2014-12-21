<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu'); ?>
    </header>

    <h1>Úprava oznamu na nástenke</h1>

    <?php if (isset($error)) { ?>
        <div class="errorMessage"><?= $error ?></div>
        <?php
    } else {
        switch ($post['section']) {
            case 1: $section_code = "rpg";
                break;
            case 2: $section_code = "non_rpg";
                break;
            case 3: $section_code = "rl";
                break;
        }
        ?>
        <form action="<?= site_url('wall/update') ?>" method="POST" id="edit_post_form">
            <input type="text" name="title" placeholder="Titulok" maxlength="255" value="<?= $post['title']; ?>" required><br>
            <input type="text" name="rpg_author" placeholder="RPG autor (voliteľné - prepíše meno účtu z ktorého to bolo poslané)" value="<?= $post['rpg_author']; ?>" maxlength="128"><br>
            <textarea name="message" cols="50" rows="10"><?= $post['message'] ?></textarea>
            <input type="hidden" name="section" value="<?= $post['section'] ?>" />
            <input type="hidden" name="section_code" value="<?= $section_code; ?>" />
            <input type="hidden" name="id" value="<?= $post['id'] ?>" />
            <input type="submit" value="Upraviť" />
        </form>
    <?php
}
?>
</div>

<?php
$this->load->view('layout/game/footer');
