<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class CustomError extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render(Request $request)
    {
        $message = $this->getMessage();

        if ($request->expectsJson()) {
            return response()->error();
        }

        return back()->with('error', $message);
    }
}
