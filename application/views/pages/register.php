<?php $this->load->view('layout/index/header', array('cssPath' => '/assets/css/register.css')); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/index/menu') ?>
    </header>
    <div class="overlay">
        <div id="content" class="margin-auto">
            <a href="#" class="fade-borders fade-background border-button">Čo je to Gallenmor?</a>
            <a href="<?= base_url('register/simple');?>" class="fade-borders fade-background border-button">Chcem sa registrovať</a>
        </div>
    </div>
</div>

<?php $this->load->view('layout/index/footer', array('scriptPath' => array('/assets/js/register.js'))); ?>