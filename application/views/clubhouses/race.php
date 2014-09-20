<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu'); ?>
    </header>

    <h1><?= $race ?></h1>
    <?php $this->load->view('clubhouses/_icons'); ?>

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
        ?>
        <button>Pridaj príspevok</button>


        <form action="<?= site_url('clubhouses/addPost') ?>" method="POST" id="new_message_form">
            <textarea name="message" cols="50" rows="10"></textarea>
            <input type="hidden" name="place" value="<?= $race ?>" />
            <input type="submit" value="Odoslať" />
        </form>

        <?php
        if (count($posts) == 0) {
            echo "<tr><td>V klubovni nie sú žiadne správy</td></tr>";
        }
        foreach ($posts as $post) {
            $this->load->view('clubhouses/_post', $post);
        }
    }
    ?>
</div>

<?php
$this->load->view('layout/game/footer');
