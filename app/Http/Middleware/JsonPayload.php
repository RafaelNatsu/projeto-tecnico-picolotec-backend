<?php

namespace App\Http\Middleware;

use App\Http\Resources\ErrorResource;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonPayload
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $content = $request->getContent();
        if ($content){
            json_decode($content);
            if (json_last_error() != JSON_ERROR_NONE) {
                return (new ErrorResource([
                    'message'=> "Format error.",
                    'code' => Response::HTTP_BAD_REQUEST
                    ]))->response()->setStatusCode(Response::HTTP_BAD_REQUEST);
            }
        }
        return $next($request);
    }
}
