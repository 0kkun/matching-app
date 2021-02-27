<?php

return [
    /**
     * APIのレスポンスフォーマット
     */
    'response_format' => [
        'status'  => '',
        'message' => '',
        'data'    => '',
    ],
    /**
     * APIのレスポンスステータスコード
     */
    'result_status' => [
        'success'      => 200,
        'created'      => 201,
        'deleted'      => 202,
        'updated'      => 203,
        'no_content'   => 204,
        'bad_request'  => 400,
        'unauthorized' => 401,
        'server_error' => 500
    ],
    'messages' => [
        200 => '',
        201 => 'created',
        202 => 'deleted',
        203 => 'updated',
        204 => 'no content',
        400 => 'bad request',
        401 => 'auth error',
        500 => 'internal server error'
    ]
];