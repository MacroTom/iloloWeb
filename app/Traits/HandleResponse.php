<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

trait HandleResponse
{
    public function determineRequestOrigin(Request $request) :String
    {
        return $request->is('api/*') ? 'api' : 'web';
    }

    public function respond(Request $request, $status=true, String $message, $data = null, $error = null, $code = 400)
    {
        $returnable['message'] = $message;
        switch ($this->determineRequestOrigin($request)) {
            case 'web':
                !is_null($data) && $returnable['data'] = $data;
                !is_null($error) && array_merge($returnable, $error);
                return $status ?
                redirect()->back()->with($returnable) :
                redirect()->back()->withErrors($returnable);
            break;

            case 'api':
                !is_null($data) && $returnable['data'] = $data;
                !is_null($error) && $returnable['errors'] = $error;
                return $status ?
                response($returnable) :
                response($returnable, $code);
            break;
        }
    }

    public function success(Request $request, String $message, $data = null)
    {
        return $this->respond($request, true, message: $message, data: $data);
    }

    public function error(Request $request, String $message, $error = null, $code = 400)
    {
        return $this->respond($request, false, $message, error: $error, code: $code);
    }

    public function page(Request $request, $view, String $message, $data = null)
    {
        return $this->determineRequestOrigin($request) === 'web' ?
        Inertia::render($view):
        $this->success($request, $message, $data);
    }
}
