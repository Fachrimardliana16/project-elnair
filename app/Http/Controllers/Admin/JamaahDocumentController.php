<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jamaah;
use App\Models\Payment;
use App\Support\JamaahFileStorage;

class JamaahDocumentController extends Controller
{
    public function show(Jamaah $jamaah, string $field)
    {
        abort_unless(JamaahFileStorage::isAllowedField($field), 404);
        abort_unless(auth()->user()?->can('manage_documents') || auth()->user()?->can('manage_jamaahs') || auth()->user()?->can('manage_payments'), 403);

        $response = JamaahFileStorage::response($jamaah->{$field}, $field.'-'.$jamaah->id);
        abort_unless($response, 404);

        return $response;
    }

    public function payment(Payment $payment)
    {
        abort_unless(auth()->user()?->can('manage_payments'), 403);

        $response = JamaahFileStorage::response($payment->payment_proof, 'payment-proof-'.$payment->id);
        abort_unless($response, 404);

        return $response;
    }
}
