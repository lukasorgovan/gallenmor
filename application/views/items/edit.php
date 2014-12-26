<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu'); ?>
    </header>

    <h1>Úprava itemu</h1>
    <?php echo anchor('items', 'Späť do obchodu'); ?>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="successMessage"><?= $this->session->flashdata('success') ?></div>
    <?php endif ?>

    <?php if ($this->session->flashdata('error')) : ?>
        <div class="errorMessage"><?= $this->session->flashdata('error') ?></div>
    <?php endif ?>

    <form action="<?= site_url('items/update') ?>" method="POST">
        <input type="text" name="name" placeholder="Názov" maxlength="255" value="<?php echo $name; ?>"><br>
        <input type="file" name="img"><br>
        <input type="number" name="price" placeholder="Cena" value="<?php echo $name; ?>"><br>
        <input type="number" name="quantitiy" placeholder="Množstvo" value="<?php echo $name; ?>"><br>
        <textarea name="description"><?php echo $description; ?></textarea><br>
        Použiteľné 
        <select name="usable">
            <option value="1">Áno</option>
            <option value="0" <?php if ($usable == 0) echo "selected"; ?>>Nie</option>
        </select><br>
        Vymeniteľné 
        <select name="tradeable">
            <option value="1">Áno</option>
            <option value="0" <?php if ($tradeable == 0) echo "selected"; ?>>Nie</option>
        </select><br>
        Typ 
        <select name="type">
            <option value="bird">Vták</option>
            <option value="cape" <?php if ($type == "cape") echo "selected"; ?>>Klobúk</option>
            <option value="sword" <?php if ($type == "sword") echo "selected"; ?>>Meč</option>
            <option value="potion" <?php if ($type == "potion") echo "selected"; ?>>Elixír</option>
        </select><br>
        <input type="number" name="level" placeholder="Level" value="<?php echo $level; ?>"><br>
        <input type="number" name="char_required_use_level" placeholder="Potrebný level postavy" value="<?php echo $char_required_use_level; ?>"><br>
        Obmedzenie na rasu
        <select name="race_restriction">
            <option value="">Žiadne</option>
            <option value="svetli-elfovia" <?php if ($race_restriction == "svetli-elfovia") echo "selected"; ?>>Svetlí elfovia</option>
            <option value="juzania" <?php if ($race_restriction == "juzania") echo "selected"; ?>>Južania</option>
            <option value="severania" <?php if ($race_restriction == "severania") echo "selected"; ?>>Severania</option>
            <option value="cigani" <?php if ($race_restriction == "cigani") echo "selected"; ?>>Cigáni</option>
            <option value="temni-elfovia" <?php if ($race_restriction == "temni-elfovia") echo "selected"; ?>>Temní elfovia</option>
        </select><br>
        <input type="number" name="durability" placeholder="Trvácnosť" value="<?php echo $durability; ?>"><br>
        <input type="number" name="usages" placeholder="Počet použití" value="<?php echo $usages; ?>"><br>
        <textarea name="stats">JSON stats</textarea><br>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="submit" value="Aktualizovať">
    </form>
</div>

<?php
$this->load->view('layout/game/footer');

