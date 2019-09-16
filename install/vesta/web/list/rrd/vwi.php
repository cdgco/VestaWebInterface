<?php

/** 
*
* Vesta Web Interface
*
* Copyright (C) 2019 Carter Roeser <carter@cdgtech.one>
* https://cdgco.github.io/VestaWebInterface
*
* Vesta Web Interface is free software: you can redistribute it and/or modify
* it under the terms of version 3 of the GNU General Public License as published 
* by the Free Software Foundation.
*
* Vesta Web Interface is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with Vesta Web Interface.  If not, see
* <https://github.com/cdgco/VestaWebInterface/blob/master/LICENSE>.
*
*/

$real_path = realpath($_SERVER["DOCUMENT_ROOT"].$_SERVER['QUERY_STRING']);
if (empty($real_path)) exit;
$dir_name = dirname($real_path);
$dir_name = dirname($dir_name);
if ($dir_name != $_SERVER["DOCUMENT_ROOT"].'/rrd') exit;
header("X-Accel-Redirect: ".$_SERVER['QUERY_STRING']);
header("Content-Type: image/png");

?>