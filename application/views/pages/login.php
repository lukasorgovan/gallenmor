<?php $this->load->view('layout/index/header', array('cssPath' => '/assets/css/register.css')); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/index/menu') ?>
    </header>

    <div class="overlay">
        <?php
        echo $_SERVER['HTTP_HOST'];
        echo ENVIRONMENT;
        echo base_url();
        if (isset($error)) {
            echo $error;
        }
        ?>
        <form action="<?= site_url('login/submit_login')?>" method="post" name="user" id="user">
            <input type="text" name="login" placeholder="Email" required="required"/>
            <input type="password" name="password" placeholder="Heslo" required="required"/>
            <input type="submit"/>
        </form>
    </div>
</div>

<?php $this->load->view('layout/index/footer', array('scriptPath' => array('/assets/js/register.js'))); ?>