<?php

/**
 * @throws Exception
 */
function do_request($url, $method='GET', $data=null) {
    if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
        $parsed_url = parse_url($url);
        $context_options = array(
            'http' => array(
                'method' => $method,
                'header' => array(
                    'Accept: */*',
                    'Accept-Encoding: gzip, deflate, br',
                    'Accept-Language: pt-BR,pt;q=0.9',
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',
                    'Host: ' . $parsed_url['host'],
                    'Connection: keep-alive',
                    'Content-Length: ' . strlen($data),
                    'Content: ' . $data
                )
            )
        );

        $context = stream_context_create($context_options);

        if (($data = file_get_contents($url, false, $context)) !== false) {
            return $data;
        }
    } else throw new Exception('Invalid URL');
    return null;
}