<?php
function set_flashdata($msg) {
    $_SESSION['flashdata'] = $msg;
}

function flashdata($opening_html=null, $closing_html=null) {

    if (isset($_SESSION['flashdata'])) {

        if (!isset($opening_html)) {
            $opening_html = '<p style="color: green;">';
            $closing_html = '</p>';
        }

        echo $opening_html.$_SESSION['flashdata'].$closing_html;
        unset($_SESSION['flashdata']);
    }
}