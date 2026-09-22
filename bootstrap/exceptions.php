<?php

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return function (Exceptions $exceptions) {

    // 1. ضمان إن أي إيرور يرجع JSON
    $exceptions->shouldRenderJsonWhen(
        fn(Request $request) => $request->is('api/*') || $request->expectsJson(),
    );

    // 2. خطأ تسجيل الدخول / التوكن (401)
    $exceptions->render(function (AuthenticationException $e, Request $request) {
        return response()->json([
            'status' => 'error',
            'message' => 'يجب تسجيل الدخول أولاً أو أن التوكن غير صالح.',
        ], 401);
    });
    // 3. العنصر غير موجود (404)
    $exceptions->render(function (NotFoundHttpException $e, Request $request) {
        return response()->json([
            'status' => 'error',
            'message' => 'الصفحة أو العنصر المطلوب غير موجود.',
        ], 404);
    });

    // 4. ليس لديك صلاحية (403)
    $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
        return response()->json([
            'status' => 'error',
            'message' => 'عفواً، لا تمتلك الصلاحية للقيام بهذا الإجراء.',
        ], 403);
    });

};