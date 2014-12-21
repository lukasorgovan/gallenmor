<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu'); ?>
    </header>
    
    <h1>Administrácia</h1>
    <?php if ($this->session->flashdata('success')) : ?>
        <div class="successMessage"><?= $this->session->flashdata('success') ?></div>
    <?php endif ?>

    <?php if ($this->session->flashdata('error')) : ?>
        <div class="errorMessage"><?= $this->session->flashdata('error') ?></div>
    <?php endif ?>

    <?php
    // create characters dropdown list
    $chars_list = "<option value=\"\">Vyber postavu</option><option disabled></option>";
    foreach ($characters as $char) {
        $chars_list .= "<option value=\"" . $char['id'] . "\">" . $char['charname'] . "</option>";
    }
    ?>

    <b>Zmeň meno</b><br>
    <form action="<?php echo site_url('admin/update_name') ?>" method="POST">
        <select name="character_id">
            <?php echo $chars_list; ?>
        </select>
        <input type="text" name="name" maxlength="50" placeholder="Meno">
        <input type="submit" value="Upraviť" />
    </form>

    <br><br>
    <b>Zmeň vek</b><br>
    <form action="<?php echo site_url('admin/update_age') ?>" method="POST">
        <select name="character_id">
            <?php echo $chars_list; ?>
        </select>
        <input type="number" name="age" placeholder="Vek">
        <input type="submit" value="Upraviť" />
    </form>

    <br><br>
    <b>Zmeň rasu</b><br>
    <form action="<?php echo site_url('admin/update_race') ?>" method="POST">
        <select name="character_id">
            <?php echo $chars_list; ?>
        </select>
        <select name="race">
            <?php
            foreach ($races as $race) {
                echo "<option value=\"" . $race['codename'] . "\">" . $race['name'] . "</option>";
            }
            ?>
        </select>
        <input type="submit" value="Upraviť" />
    </form>

    <br><br>
    <b>Zmeň pohlavie</b><br>
    <form action="<?php echo site_url('admin/update_gender') ?>" method="POST">
        <select name="character_id">
            <?php echo $chars_list; ?>
        </select>
        <select name="gender">
            <option value="muž">Muž</option>
            <option value="žena">Žena</option>
        </select>
        <input type="submit" value="Upraviť" />
    </form>

</div>

<?php
$this->load->view('layout/game/footer');
