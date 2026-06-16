<?php
require 'C:\laragon\www\makerere-sports-webapp\mak-sports\vendor\autoload.php';
$loader->addPsr4('BezhanSalleh\\FilamentShield\\', 'C:\\laragon\\www\\makerere-sports-webapp\\mak-sports\\vendor\\bezhansalleh\\filament-shield\\src');
echo class_exists('BezhanSalleh\\FilamentShield\\FilamentShieldPlugin') ? 'LOADABLE' : 'NOT FOUND';
