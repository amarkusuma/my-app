<?php

namespace App\Traits;

use App\Constants\StatusConstant;

trait APIResponderHelper
{
    protected function success($message = 'Permintaan berhasil diproses', $data = [])
    {
        $response['response_status'] = StatusConstant::SUCCESS;
        $response['message'] = $message;
        $response['data'] = $data;

        return response()->json($response);
    }

    protected function failure($message = 'Permintaan gagal diproses', $data = [])
    {
        $response['response_status'] = StatusConstant::FAILURE;
        $response['message'] = $message;
        $response['data'] = $data;

        return response()->json($response);
    }

    protected function notFound($message = 'Data tidak ditemukan', $data = [])
    {
        $response['response_status'] = StatusConstant::NOT_FOUND;
        $response['message'] = $message;
        $response['data'] = $data;

        return response()->json($response);
    }

    protected function unauthorized($message = 'Anda tidak memiliki hak akses. Silakan login terlebih dahulu', $data = [])
    {
        $response['response_status'] = StatusConstant::UNAUTHORIZED;
        $response['message'] = $message;
        $response['data'] = $data;

        return response()->json($response);
    }

    protected function error($data = [])
    {
        $response['response_status'] = 500;
        $response['message'] = 'Server Error';
        $response['data'] = $data;

        return response()->json($response, 500);
    }
}
