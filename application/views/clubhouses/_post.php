<?php
echo $username . "<br>" . $created . "<br>" . $message . "<br>";

if ($user_id == $this->session->userdata('id')) {
    echo anchor('clubhouses/edit/' . $id, 'Upraviť');
    ?>
    <form action="<?= site_url('clubhouses/deletePost') ?>" method="POST" class="delete_post_form">
        <input type="hidden" name="codename" value="<?= $codename ?>" />
        <input type="hidden" name="id" value="<?= $id ?>" />
        <input type="submit" value="Odstrániť" />
    </form>
    <?php
}
?>
<br><br>