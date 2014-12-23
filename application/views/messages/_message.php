<?php

if ($delivered > time()) {
    if ($u1username != $this->session->userdata('username')) {
        return;
    } // don't display message which has not been delivered yet
    else {
        echo "Táto správa je zatiaľ na ceste za príjemcom.<br>";
    }
}
echo $u1username . "<br>" . $created . "<br>" . $message . "<br><br>";
