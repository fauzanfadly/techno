<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Response;


class ResponseServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Response $response)
    {
        $response->macro('success', function ($data, $message = 'Your request is success', $code = 200) {
            return response()->json([
                'status' => 'SUCCESS',
                'code' => $code,
                'message' => $message,
                'data' => $data,
            ], $code);
        });

        $response->macro('error', function ($message = 'Sorry, something went wrong', $code = 400) {
            return response()->json([
                'status' => 'ERROR',
                'code' => $code,
                'message' => $message,
            ], $code);
        });

        $response->macro('errorValidation', function ($validations = [], $message = 'Failed to process your request, please check the request payload body / query parameters') {
            return response()->json([
                'status' => 'ERROR',
                'code' => 400,
                'message' => $message,
                'validations' => $validations
            ], 400);
        });

        $response->macro('notFound', function ($message = 'Url not found') {
            return response()->json([
                'status' => 'ERROR',
                'code' => 404,
                'message' => $message,
            ], 404);
        });
    }
}
