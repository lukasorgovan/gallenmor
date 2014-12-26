<?php

echo img('assets/images/items/' . $img, TRUE);
echo "<br>";
echo $name . "<br>" . $description . "<br>Cena: " . $price . "<br>";
if ($race_restriction != NULL) {
    echo "<i>Len pre rasu $r_name</i>";
}
if ($admin) {
    echo "<br>";
    echo anchor('items/edit/' . $id, 'Upraviť');
    echo anchor('items/delete/' . $id, ' Zmazať', array('onclick' => "return confirm('Naozaj chceš zmazať item? (Nie je možné vrátiť späť)')"));
}
echo "<br><br>";
