<?php $this->load->view('header', array('cssPath' => '/assets/css/register.css')); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('menus/index_menu') ?>
    </header>

    <div class="overlay">
        <?php
        if (isset($error)) {
            echo $error;
        }
        ?>
        <form action="<?= site_url('login/submitLogin')?>" method="post" name="user" id="user">
            <input type="text" name="login" placeholder="Email" required="required"/>
            <input type="password" name="password" placeholder="Heslo" required="required"/>
            <input type="submit"/>
        </form>
    </div>
</div>

<?php $this->load->view('footer', array('scriptPath' => array('/assets/js/register.js'))); ?>