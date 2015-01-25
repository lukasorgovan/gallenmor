<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu') ?>
    </header>

    <h1>Správa postáv na účte</h1>
    <p>Na svojom účte môžeš mať naraz 5 postáv. Pridávať a odstraňovať si ich môžeš sám kedykoľvek.</p>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="successMessage"><?= $this->session->flashdata('success') ?></div>
    <?php endif ?>

    <?php if ($this->session->flashdata('error')) : ?>
        <div class="errorMessage"><?= $this->session->flashdata('error') ?></div>
    <?php endif ?>

    <?php if (!$own_account && !$admin) : ?>
        <div class="errorMessage">Nemôžeš manipulovať s postavami na inom účte</div>
    <?php endif ?>   
    <h2>Tvoje postavy</h2>
    <table>
        <?php
        if (count($characters) == 0) {
            echo "<tr><td>Na tvojom účte nie sú žiadne postavy</td></tr>";
        }
        foreach ($characters as $char) {
            ?>
            <tr>
                <td><strong><?= $char['charname']; ?></strong></td>
                <td><form action="<?= site_url('profile/del_character') ?>" method="POST">
                        <input type="hidden" name="delete_character" id="delete_character" value="<?= $char['id']; ?>"/>
                        <input type="hidden" name="account_id" value="<?= $account_id; ?>"/>
                        <input type="submit" value="Zmazať postavu" class="button-delete" onclick="return confirm('Skutočne chceš zmazať túto postavu? Tento krok je nevratný.')"/>
                    </form>
                </td>
            </tr>
        <?php }
        ?>
    </table>
    <?php
    if (count($characters) < 5 || $admin) {
        /* To-Do: include stuff as on registration page */
        ?>
        <h2>Vytvoriť novú postavu</h2>
        <form action="<?= site_url('profile/add_character') ?>" method="POST">
            <input type="hidden" name="race" id="race" class="step-2" value="svetli-elfovia"/>
            <div class="race-pick">
                <span class="scroller-arrow arrow-left" data-dir="left">&larr;</span>
                <div class="erbs" id="scroll-wrapper">
                    <div class="scroller">
                        <div class="erb erb-svetli-elfovia"></div>
                        <div class="erb erb-juzania"></div>
                        <div class="erb erb-severania"></div>
                        <div class="erb erb-cigani"></div>
                        <div class="erb erb-temni-elfovia"></div>
                    </div><!-- scroll-wrapper -->
                </div><!-- erbs -->
                <span class="scroller-arrow arrow-right" data-dir="right">&rarr;</span>
                <div id="msg-race" class="error"></div>
            </div><!-- race pick -->
            <select name="gender">
                <option value="muž">Muž</option>
                <option value="žena">Žena</option>
            </select>
            <div id="msg-gender" class="error"></div>
            <input type="text" name="charname" id="charname" placeholder="meno postavy" required="required"/><div id="msg-charname" class="error"></div>
            <div id="generator">G</div>
            <label for="age" id="ageLabel">Vek postavy</label>
            <span id="age-output" class="age-output step-3">35</span>
            <input type="range" name="age" min="20" max="50" value="35"/>
            <div id="msg-age" class="error"></div>
            <input type="hidden" name="account_id" value="<?= $account_id; ?>"/>
            <input type="submit" value="Vytvoriť postavu" class="button"/>
        </form>
        <?php
    }
    ?>
</div>


<?php $this->load->view('layout/game/footer'); ?>