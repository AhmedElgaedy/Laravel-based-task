<?php

use Illuminate\Pagination\LengthAwarePaginator;

if (!function_exists('apiResponse')) {
    /**
     * Generate a standardized API response.
     *
     * @param string|null $code
     * @param string $status
     * @param string|null $message
     * @param mixed|null $data
     * @param array|null $meta
     * @return \Illuminate\Http\JsonResponse
     */
    function apiResponse($code = null, $status = 'success', $message = null, $data = null, $meta = null)
    {
        $response = [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];

        if ($meta) {
            $response['meta'] = [
                'total' => $meta['total'] ?? null,
                'totalPages' => $meta['totalPages'] ?? null,
                'perPage' => $meta['perPage'] ?? null,
                'currentPage' => $meta['currentPage'] ?? null,
                'lastPage' => $meta['lastPage'] ?? null,
            ];
        }
        return response()->json($response);
    }

    /**
     * Get pagination meta data from a LengthAwarePaginator instance.
     *
     * @param LengthAwarePaginator $paginator
     * @return array
     */
    function getPaginationMeta(LengthAwarePaginator $paginator)
    {
        return [
            'total' => $paginator->total(),
            'totalPages' => $paginator->lastPage(),
            'perPage' => $paginator->perPage(),
            'currentPage' => $paginator->currentPage(),
            'lastPage' => $paginator->lastPage(),
        ];
    }
}
