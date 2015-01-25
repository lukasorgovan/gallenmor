<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu'); ?>
    </header>

    <h1>Obchod</h1>
    <?php
    if ($admin) {
        echo anchor('items/admin', 'Administrácia');
        echo "<br><br>";
    }
    ?>
    <?php echo anchor('items/section/capes', 'Klobúky'); ?><br>
    <?php echo anchor('items/section/birds', 'Vtáky'); ?><br>
    <?php echo anchor('items/section/swords', 'Meče'); ?><br>
    <?php echo anchor('items/section/potions', 'Elixíry'); ?><br>
</div>

<?php
$this->load->view('layout/game/footer');

