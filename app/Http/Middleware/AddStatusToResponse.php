<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddStatusToResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if($request->expectsJson()){
            
            if ($response->getContent()) {
                $codeResponse   = $response->getStatusCode();
                $status         = $codeResponse >= 200 && $codeResponse <= 299 ? 'success' : 'error';
                $data           = collect(json_decode($response->getContent(), true));
                $data           = !isset($data->data) && $status == 'success' ? collect(['data' => $data]) : $data;

                $data->prepend($codeResponse, 'code');
                $data->prepend($status, 'status');

                $response->setContent(json_encode($data->toArray()));
            }

        }

        return $response;
    }
}
