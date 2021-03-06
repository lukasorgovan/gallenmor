<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu'); ?>
    </header>

    <h1>Oznamy</h1>
    <h2><?= $section_name ?></h2>
    <?php
    $this->load->view('wall/_icons');
    ?>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="successMessage"><?= $this->session->flashdata('success') ?></div>
    <?php endif ?>

    <?php if ($this->session->flashdata('error')) : ?>
        <div class="errorMessage"><?= $this->session->flashdata('error') ?></div>
    <?php endif ?>


    <?php if (isset($error)) { ?>
        <div class="errorMessage"><?= $error ?></div>
        <?php
    } else {
        if ($this->session->userdata('authority') == 99) {
            ?>
            <button onclick="$('#new_message_form').slideToggle()">Pridaj príspevok</button><br>


            <form action="<?= site_url('wall/create') ?>" method="POST" id="new_message_form" style="display: none">
                <input type="text" name="title" placeholder="Titulok" maxlength="255" required><br>
                <input type="text" name="rpg_author" placeholder="RPG autor (voliteľné - prepíše meno účtu z ktorého to bolo poslané)" maxlength="128"><br>
                <textarea name="message" cols="50" rows="10" required></textarea>
                <input type="hidden" name="section" value="<?= $section ?>" />
                <input type="hidden" name="section_name" value="<?= $this->uri->segment(2); ?>" />
                <input type="submit" value="Odoslať" />
            </form>

            <?php
        }

        if (count($posts) == 0) {
            echo "<tr><td>V tejto sekcii nie sú žiadne príspevky</td></tr>";
        }
        foreach ($posts as $post) {
            $post['author'] = (isset($post['rpg_author']) && $post['rpg_author'] != "") ? $post['rpg_author'] : $post['username'];
            $post['section_code'] = $this->uri->segment(2);
            $this->load->view('wall/_post', $post);
        }
    }
    ?>
</div>

<?php
$this->load->view('layout/game/footer');
