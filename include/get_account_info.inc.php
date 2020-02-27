<?php

function getAccountInfo() {
    if (isset($_SESSION['login'])) {
        require_once 'classes/DBRequest.class.php';

        $request = new DBRequest();
        return $request->getAccountInfo($_SESSION['login']);
    }
}