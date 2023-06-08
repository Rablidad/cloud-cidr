<?php

define ('DEPENDENCIES_DIR', __DIR__ . '/dependencies/');
define('AWS_IPRANGES_ENDPOINT', 'https://ip-ranges.amazonaws.com/ip-ranges.json');

require DEPENDENCIES_DIR . 'requests/src/Autoload.php';
require DEPENDENCIES_DIR . 'leaf/autoloader.php';

use WpOrg\Requests\Requests;
use WpOrg\Requests\Autoload;
use Leaf\App;

// register requests autoloader
Autoload::register();

// create leaf routing app object
$app = new App();

// get route for aws ip-ranges
$app->get('/aws', function() {
    $data = Requests::get(AWS_IPRANGES_ENDPOINT);
    if ($data->status_code === 200) {
        if (($json = json_decode($data->body)) !== null) {
            $aws_ips = array();
            foreach ($json->prefixes as $prefix) {
                if ($prefix->service === 'EC2') {
                    $aws_ips[$prefix->region][] = $prefix->ip_prefix;
                }
            }
            echo json_encode($aws_ips);
        }
    }
});


$app->run();
