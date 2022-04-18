<?php

/**
 * CSS
 */
$css = new \MatthiasMullie\Minify\CSS();
$css->add(PATH['assets'] . '/css/style.css');
$css->add(PATH['assets'] . '/css/form.css');
$css->add(PATH['assets'] . '/css/button.css');
$css->add(PATH['assets'] . '/css/message.css');
$css->add(PATH['assets'] . '/css/load.css');
$css->minify(PATH['assets'] . '/css/style.min.css');

/**
 * JS
 */
$js = new \MatthiasMullie\Minify\JS();
$js->add(PATH['assets'] . '/js/jquery.js');
$js->add(PATH['assets'] . '/js/jquery-ui.js');
$js->minify(PATH['assets'] . '/js/scripts.min.js');
