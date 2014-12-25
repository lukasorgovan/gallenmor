<?php

echo img('assets/images/items/' . $img, TRUE);
echo "<br>";
echo $name . "<br>" . $description . "<br>Cena: " . $price . "<br>";
if ($race_restriction != NULL) {
    echo "<i>Len pre rasu $r_name</i>";
}
echo "<br><br>";