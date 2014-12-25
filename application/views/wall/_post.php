<?php
echo $title . "<br>" . $author . ", ". $created ."<br>" . $message . "<br>";

if ($user_id == $this->session->userdata('id') || $this->session->userdata('authority') == 99) {
    echo anchor('wall/edit/' . $id, 'Upraviť');
    ?>
    <form action="<?= site_url('wall/delete') ?>" method="POST" class="delete_post_form">
        <input type="hidden" name="section_code" value="<?= $section_code ?>" />
        <input type="hidden" name="id" value="<?= $id ?>" />
        <input type="submit" value="Odstrániť" />
    </form>
    <?php
}
?>
<br><br>