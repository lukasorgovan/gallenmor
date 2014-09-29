<?php
// To-Do: Use javascript to prevent clicking on links with disabled class.

// Important: Following css style is for basic visualization. Needs to be removed later.
?>
<style>
    a.disabled {
        color: grey;
    }
</style>



<?php
$d = "";
if(!in_array('severania', $races)) {
    $d = " disabled";
}
echo anchor('clubhouses/race/severania', 'Severania', array('class' => 'race-icon-link'.$d));

$d = "";
if(!in_array('svetli-elfovia', $races)) {
    $d = " disabled";
}
echo anchor('clubhouses/race/svetli-elfovia', 'Svetlí Elfovia', array('class' => 'race-icon-link'.$d));

$d = "";
if(!in_array('temni-elfovia', $races)) {
    $d = " disabled";
}
echo anchor('clubhouses/race/temni-elfovia', 'Temní Elfovia', array('class' => 'race-icon-link'.$d));

$d = "";
if(!in_array('cigani', $races)) {
    $d = " disabled";
}
echo anchor('clubhouses/race/cigani', 'Cigáni', array('class' => 'race-icon-link'.$d));

$d = "";
if(!in_array('juzania', $races)) {
    $d = " disabled";
}
echo anchor('clubhouses/race/juzania', 'Južania', array('class' => 'race-icon-link'.$d));
