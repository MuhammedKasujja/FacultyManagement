<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendResponse($message = "", $success_code = "", $result = [])
    {

        $response = ['success' => true, 'data' => []];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        if (!empty($success_code)) {
            $response['code'] = $success_code;
        }

        if (!empty($result)) {
            $response['data'] = $result;
        }

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function sendError($error, $error_code = 101, $error_data = [])
    {

        $response = ['success' => false, 'error' => $error, 'error_code' => $error_code];

        if (!empty($error_data)) {
            $response['data'] = $error_data;
        }

        return response()->json($response, 200);
    }
}
