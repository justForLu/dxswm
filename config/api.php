<?php

return [
    'page_size' => 10,
    'uploadImg' => '/upload/admin/image',
    'document_root' => $_SERVER['DOCUMENT_ROOT'],
    'api_url' => 'http://www.dxswm.com',
    'school_id_key' => $_SERVER['JWT_SECRET'].'_school_id',     //高校ID的key
    'default_school_id' => 1,   //默认高校ID
];
