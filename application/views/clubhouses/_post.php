<?php
echo $username . "<br>" . $created . "<br>" . $message . "<br>";

if ($user_id == $this->session->userdata('id')) {
    echo anchor('clubhouses/edit/' . $id, 'Upraviť');
    ?>

    <?php
}
?>
<br><br>