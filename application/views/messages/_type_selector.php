<form action="#" method="get" id="type_form" onsubmit="return loadMessageForm();">
    <input type="radio" name="t" value="post">Pošta<br>
    <input type="radio" name="t" value="bird">Vták <span id="bird_return">Tvoj vták sa vráti za <span id="time_remaining"></span></span><br>
</form>

<?php
if ($bird_available > $curtime) {
    ?>
    <script>
        // from stackoverflow. just simple prototype...
        var sPerDay = 24 * 60 * 60;

        window.setInterval(function () {
            var today = new Date();
            var timeLeft = <?php echo $bird_available; ?> - today.getTime() / 1000;


            var e_daysLeft = timeLeft / sPerDay;
            var daysLeft = Math.floor(e_daysLeft);

            var e_hrsLeft = (e_daysLeft - daysLeft) * 24;
            var hrsLeft = Math.floor(e_hrsLeft);

            var e_minsLeft = (e_hrsLeft - hrsLeft) * 60;
            var minsLeft = Math.floor(e_minsLeft);

            var e_secsLeft = (e_minsLeft - minsLeft) * 60;
            var secsLeft = Math.floor(e_secsLeft);


            var timeString = minsLeft + " : " + secsLeft;
            $('#time_remaining').html(timeString);
        }, 1000);
    </script>
    <?php
}