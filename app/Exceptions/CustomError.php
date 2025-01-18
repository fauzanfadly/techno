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
        $message = !empty($this->message) ? $this->message : $this->getMessage();

        if ($request->expectsJson()) {
            return response()->error($message);
        }

        return back()->with('error', $message);
    }
}
