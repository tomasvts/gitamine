<?php
declare(strict_types=1);

$autoloadFile = './vendor/codeception/codeception/autoload.php';
if (file_exists('./vendor/autoload.php') && file_exists($autoloadFile) && __FILE__ !== realpath($autoloadFile)) {
    //for global installation or phar file
    fwrite(
        STDERR,
        "\n==== Redirecting to Composer-installed version in vendor/codeception ====\n"
    );
    require $autoloadFile;
    //require package/bin instead of codecept to avoid printing hashbang line
    require './vendor/codeception/codeception/package/bin';
    die;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    // for phar
    require_once __DIR__ . '/vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../../autoload.php')) {
    //for composer
    require_once __DIR__ . '/../../autoload.php';
}
unset($autoloadFile);
