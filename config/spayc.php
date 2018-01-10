<?php
return [
    'title' =>'SPAYC',
    'gender'=>['male','female','other'],
    'spayctype'=>['Event','Community'],
    'grouptype'=>['Public','Private'],
    'maxupload'=>'2MB',
    'adminEmail' =>'kiwitech@gmail.com',
    'MATRIX'=>[
        'url'=>'https://35.168.119.247:8448/_matrix/client/r0',
        'sslverify' => false,
    ],
    'AWS3'=>[
        'url'=> "https://s3.amazonaws.com",
        'key' => "AKIAIH4QMAKCPTDCJVOA",
        'secret' => "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",
        'bucket' => "spayc-qa",
        'region' => 'us-east-1',
        'version' => '2006-03-01'
    ]
];
