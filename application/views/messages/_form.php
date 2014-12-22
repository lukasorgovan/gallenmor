<form action = "<?= site_url('messages/send') ?>" method = "POST">
    <?php if (!isset($user_id)) { ?>
        <select name="user">
            <?php
            foreach ($users as $user) {
                ?>
                <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
            <?php }
            ?>
        </select>
    <?php } else { ?>
        <input type="hidden" name="user" value="<?php echo $user_id; ?>">
    <?php } ?>
    <textarea name="message" cols="50" rows="10"><?php
        if ($this->session->flashdata('message')) {
            echo $this->session->flashdata('message');
        }
        ?></textarea>
    <input type="hidden" name="conv_id" value="<?= $this->uri->segment(3) ? $this->uri->segment(3) : 0 ?>">
    <input type="submit" value="Odoslať správu" class="button"/>
</form>