<?php

function Deliver()
{
    return  $_SESSION['auth-deliver'] ?? false;
}

function Employee()
{
    return  $_SESSION['auth-employee'] ?? false;
}

function auth()
{
    return $_SESSION['auth-logged'];
}

/*
*    Debug
*/
function st($string)
{
    if ($string) {
        echo '<pre>';
        print_r($string);
        echo '</pre>';
    }
    return ' ';
}

function getColor($number)
{
    if ($number < 20) {
        return 'danger';
    }
    if ($number < 50 and $number > 20) {
        return 'primary';
    }
    if ($number < 70 and $number > 50) {
        return 'info';
    }
    if ($number > 70) {
        return 'success';
    }
}

/*
*    Debug
*/
function sv($string)
{
    st($string);
    exit;
}

function dd($string)
{
    return sv($string);
}




/*
* Clean POST data
*/
function clean($post)
{
    $clean = [];
    if (is_array($post)) {
        foreach ($post as $key => $value) :
            $clean[$key] = clean($value);
        endforeach;
        return $clean;
    } else {
        return safe($post);
    }
}





/*
*    Clean the Inputs
*/
function safe($data)
{
    // Strip HTML Tags
    $clear = strip_tags($data);
    // Clean up things like &amp;
    $clear = html_entity_decode($clear);
    // Strip out any url-encoded stuff
    $clear = urldecode($clear);
    // Replace Multiple spaces with single space
    $clear = preg_replace('/ +/', ' ', $clear);
    // Trim the string of leading/trailing space
    $clear = trim($clear);
    return $clear;
}



/** */

function getInstanceStatus()
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ultramsg.com/instance9871/instance/status?token=bh1p6r44gb0bendu",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return [
            'status' => false,
            "error" => $err
        ];
    } else {
        return [
            'status' => true,
            "response" => $response
        ];
    }
}

function isAuthenticated()
{
    $data = getInstanceStatus();
    return json_decode($data['response'], true)['status']['accountStatus']['status'] !== 'qr';
}

function isInit()
{
    $data = getInstanceStatus();
    return json_decode($data['response'], true)['status']['accountStatus']['status'] === 'initialize';
}

function isInitialized()
{
    $data = getInstanceStatus();
    return json_decode($data['response'], true)['status']['accountStatus']['status'] === 'qr';
}

function logoutFomInstance()
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ultramsg.com/instance9871/instance/logout",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "token=bh1p6r44gb0bendu",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return [
            'status' => false,
            'error' => $err
        ];
    } else {
        return [
            'status' => true,
            'response' => $response
        ];
    }
}

function getQrCode()
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ultramsg.com/instance9871/instance/qr?token=bh1p6r44gb0bendu",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return  [
            'status' => false,
            'error' => $err
        ];
    } else {
        return  [
            'status' => true,
            'response' => $response
        ];
    }
}
