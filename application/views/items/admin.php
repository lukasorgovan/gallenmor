<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu'); ?>
    </header>

    <h1>Správa itemov</h1>
    <?php echo anchor('items', 'Späť do obchodu'); ?>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="successMessage"><?= $this->session->flashdata('success') ?></div>
    <?php endif ?>

    <?php if ($this->session->flashdata('error')) : ?>
        <div class="errorMessage"><?= $this->session->flashdata('error') ?></div>
    <?php endif ?>

    <h2>Vytvorenie itemu</h2>
    <form action="<?= site_url('items/create') ?>" method="POST">
        <input type="text" name="name" placeholder="Názov" maxlength="255"><br>
        <input type="file" name="img"><br>
        <input type="number" name="price" placeholder="Cena"><br>
        <input type="number" name="quantitiy" placeholder="Množstvo"><br>
        <textarea name="description">Popis</textarea><br>
        Použiteľné 
        <select name="usable">
            <option value="1">Áno</option>
            <option value="0">Nie</option>
        </select><br>
        Vymeniteľné 
        <select name="tradeable">
            <option value="1">Áno</option>
            <option value="0">Nie</option>
        </select><br>
        Typ 
        <select name="type">
            <option value="bird">Vták</option>
            <option value="cape">Klobúk</option>
            <option value="sword">Meč</option>
            <option value="potion">Elixír</option>
        </select><br>
        <input type="number" name="level" placeholder="Level"><br>
        <input type="number" name="char_required_use_level" placeholder="Potrebný level postavy"><br>
        Obmedzenie na rasu
        <select name="race_restriction">
            <option value="">Žiadne</option>
            <option value="svetli-elfovia">Svetlí elfovia</option>
            <option value="juzania">Južania</option>
            <option value="severania">Severania</option>
            <option value="cigani">Cigáni</option>
            <option value="temni-elfovia">Temní elfovia</option>
        </select><br>
        <input type="number" name="durability" placeholder="Trvácnosť"><br>
        <input type="number" name="usages" placeholder="Počet použití"><br>
        <textarea name="stats">JSON stats</textarea><br>
        <input type="submit" value="Vytvoriť">
    </form>
</div>

<?php
$this->load->view('layout/game/footer');

