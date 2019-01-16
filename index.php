<?php
// フロントコントローラ(htaccessファイルで定義する)
// 全てのリクエストをこのファイルで受け取ります。

require 'booter.php';
                
$application = new Application();
$application->run();





