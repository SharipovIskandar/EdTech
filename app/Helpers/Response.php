<?php

<?php

function success_response($result, int $code = 200, $errors = null, $extra = null)
{
    return response()->json(
        array_merge(
            [
                'result' => $result,
                'errors' => $errors,

            ],
            $extra ? ['extra' => $extra] : [],
        ),
        $code
    );
}

function integration_response($result, int $code = 200, $errors = null)
{
    return response()->json(
        [
            'result' => $result,
            'errors' => $errors
        ],
        $code
    );
}

function success_paginate($collection, int $code = 200, $extra = null)
{
    $pagination = [
        'current_page' => $collection->currentPage(),
        'per_page' => $collection->perPage(),
        'last_page' => $collection->lastPage(),
        'total' => $collection->total(),
        'count' => $collection->count(),
    ];

    return response()->json(
        array_merge(
            [
                'result' => $collection,
                'pagination' => $pagination,

            ],
            $extra ? ['extra' => $extra] : [],
        ),
        $code
    );
}

function error_response($errors, int $code = 400, $datas = null)
{
    return response()->json(
        [
            'result' => null,
            'errors' => $errors,
            'datas' => $datas,
        ],
        $code
    );
}

function exception_response($message, $datas, $line, $file, int $code)
{
    return response()->json(
        [
            'errors' => $message,
            'datas' => $datas,
            'located' => [
                'file' => $file,
                'line' => $line
            ]
        ],
        $code
    );
}

function stream_response($stream, $id = null, $event = 'update', $usleep = 500)
{
    return response()->stream(
        function () use ($stream, $id, $usleep, $event) {
            foreach ($stream ?: [] as $data) {
                usleep($usleep);
                if (connection_aborted()) {
                    break;
                }
                echo "id: $id\n";
                echo "event: update\n";
                echo 'data: ' . $data . ' ';
                echo "\n\n";
                ob_flush();
                flush();
            }

            echo "id: $id\n";
            echo "event: $event\n";
            echo 'data: <END_STREAMING_SSE>';
            echo "\n\n";
            ob_flush();
            flush();
        },
        200,
        [
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
            'Content-Type' => 'text/event-stream',
        ]
    );
}
