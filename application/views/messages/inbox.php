<?php $this->load->view('layout/game/header'); ?>

<div id="wrapper" class="margin-auto">
    <header>
        <?php $this->load->view('layout/game/menu') ?>
    </header>

    <?php $this->load->view('messages/_menu'); ?>
    <h1>Tvoje konverzácie</h1>

    <table>
        <?php
        if (count($messages) == 0) {
            echo "<tr><td>Nemáš žiadne správy</td></tr>";
        }
        foreach ($messages as $msg) {
            ?>
            <tr>
                <td>
                    <?php
                    if ($msg['from_user_id'] == $this->session->userdata('id')) {
                        echo $msg['u2username'];
                    } else {
                        echo $msg['u1username'];
                    }
                    ?>
                </td>
                <td><?= $msg['created'] ?></td>
                <td><?= anchor('messages/conversation/'.$msg['id'], 'Zobraziť konverzáciu'); ?></td>
            </tr>
        <?php }
        ?>
    </table>
</div>

<?php $this->load->view('layout/game/footer'); ?>