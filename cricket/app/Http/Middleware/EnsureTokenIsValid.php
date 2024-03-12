<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cricktownHost = $request->header('X-Crictown28Infotech-Host');
        $cricktownKey = $request->header('X-Crictown28Infotech-Key');
        $cricktownHost = 'cricktown.28infotech.com';
        // $cricktownKey = '9f4h197fk6clwpqlx6f469x17cp5v42l568vmej4lsn469x183';
        $keyCollection = [
            '9f4h197fk6clwpqlx6f469x17cp5v42l568vmej4lsn469x183', // current token
            'f4e78le451dmwlfha1flr732f8r437l54913lej1ls154m4g48', // next token
        ];

        if ($cricktownHost !== 'cricktown.28infotech.com' || !in_array($cricktownKey, $keyCollection)) {
            abort(403, 'Authorization flailed');
        }
        return $next($request);
    }
}
