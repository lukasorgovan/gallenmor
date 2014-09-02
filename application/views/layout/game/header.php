<!DOCTYPE html>
<html lang="sk">
    <head>
        <meta charset="utf-8">
        <title>Gallenmor - rpg svet: zaži svoje dobrodružstvo</title>
        <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>" />
        <link rel="stylesheet" href="<?= base_url('assets/css/reveal.css') ?>" />
        <?php
        if (isset($cssPath)) {
            echo '<link rel="stylesheet" href="' . base_url($cssPath) . '" />';
        }
        ?>

        <link rel="icon" type="image/png" href="<?= base_url('favicon.ico') ?>" />
        <link href='http://fonts.googleapis.com/css?family=Metamorphous&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css' />
        <link href='http://fonts.googleapis.com/css?family=Gentium+Basic:400,700,400italic&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <style>
            <!-- 
            /* Nechcem sa sparat v css suboroch a zaroven mi prekaza to pozadie,
            takze takto.... */
            #wrapper {
                background: #000 !important;
                padding-top: 0px !important;
            }
            -->
        </style>
    </head>
    <body <?php
    if (isset($bodyClass)) {
        echo 'class="' . $bodyClass . '"';
    }
    ?>>