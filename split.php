<?php

    // Replace ACuser & ACkey to authenticate with your account.

    $ACuser = 'yourusernamehere';
    $ACkey = '000000000000000000000000000000000000000000000000000000000000000000000000';
    $perstag = 'SPLIT_PATH';


    // This generates a random A or B.

    function randLetter(){
        $int = rand(0,1);
        $a_z = "AB";
        $rand_letter = $a_z[$int];
        return $rand_letter;
    }


    // This searches for the field ID of the %SPLIT_PATH% custom field.

    $url = 'https://'.$ACuser.'.api-us1.com/api/3/fields?limit=9999999';
    $cURL = curl_init();
    curl_setopt($cURL, CURLOPT_URL, $url);
    curl_setopt($cURL, CURLOPT_HTTPGET, true);
    curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Api-token: '.$ACkey ,
        'Accept: application/json'
    ));
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($cURL);
    $result = json_decode($result);
    
    $fields = $result->fields;

    foreach($fields as $item) {
        if($item->perstag == $perstag){
            $field_id = $item->id;
        }   
    }


    // This sets the custom field to the result of the randLetter() function.

    $url = 'https://'.$ACuser.'.api-us1.com/api/3/fieldValues';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_POSTFIELDS, '{
        "fieldValue": {
            "contact": '.$_POST['contact']['id'].',
            "field": '.$field_id.',
            "value": "'.randLetter().'"
        }
    }'
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Api-token: '.$ACkey 
    ));
    $response = curl_exec($curl);
    curl_close($curl);
?>