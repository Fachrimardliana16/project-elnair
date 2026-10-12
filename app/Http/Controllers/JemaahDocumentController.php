<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Support\JamaahFileStorage;
use Illuminate\Http\Request;

class JemaahDocumentController extends Controller
{
    public function show(Request $request, string $field)
    {
        abort_unless(JamaahFileStorage::isAllowedField($field), 404);

        $jemaah = $request->get('jemaah');
        abort_unless($jemaah, 403);

        $response = JamaahFileStorage::response($jemaah->{$field}, $field.'-'.$jemaah->id);
        abort_unless($response, 404);

        return $response;
    }

    public function payment(Request $request, Payment $payment)
    {
        $jemaah = $request->get('jemaah');
        abort_unless($jemaah && $payment->jamaah_id === $jemaah->id, 403);

        $response = JamaahFileStorage::response($payment->payment_proof, 'payment-proof-'.$payment->id);
        abort_unless($response, 404);

        return $response;
    }
}
