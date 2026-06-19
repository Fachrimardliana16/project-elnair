<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jamaah;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('jamaah.package')->latest()->paginate(10);

        // Calculate Outstanding Payments (Jemaahs who haven't fully paid their package)
        $jamaahs = Jamaah::with(['package', 'payments'])->get();
        $outstandingList = [];

        foreach ($jamaahs as $j) {
            if (! $j->package) {
                continue;
            }

            $packagePrice = $this->parsePrice($j->package->price_value);
            $totalPaid = (float) $j->payments->where('status', 'Approved')->sum('amount');
            $balance = max(0.0, $packagePrice - $totalPaid);

            if ($balance > 0) {
                // Determine a dummy due date (e.g. 30 days before departure schedule or 30 days after creation)
                $dueDate = $j->created_at->addDays(30);
                $outstandingList[] = [
                    'jamaah' => $j,
                    'package_price' => $packagePrice,
                    'total_paid' => $totalPaid,
                    'balance' => $balance,
                    'due_date' => $dueDate,
                ];
            }
        }

        return view('admin.payment.index', compact('payments', 'outstandingList'));
    }

    public function create(Request $request)
    {
        $selectedJamaah = null;
        if ($request->has('jamaah_id')) {
            $selectedJamaah = Jamaah::with('package')->findOrFail($request->jamaah_id);
        }

        $jamaahs = Jamaah::where('status', '!=', 'Selesai')->get();

        return view('admin.payment.create', compact('jamaahs', 'selectedJamaah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jamaah_id' => 'required|exists:jamaahs,id',
            'type' => 'required|in:DP,Cicilan 1,Cicilan 2,Pelunasan',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['jamaah_id', 'type', 'amount', 'payment_date']);
        $data['status'] = 'Approved'; // Directly approve manual/admin payments

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payments', 'public');
            $data['payment_proof'] = $path;
        }

        $payment = Payment::create($data);

        // Recalculate Jamaah Status
        $this->updateJamaahStatus($payment->jamaah_id);

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        $payment->update(['status' => $request->status]);

        // Recalculate Jamaah Status
        $this->updateJamaahStatus($payment->jamaah_id);

        return redirect()->back()->with('success', "Status pembayaran berhasil diubah menjadi {$request->status}.");
    }

    public function destroy(Payment $payment)
    {
        $jamaahId = $payment->jamaah_id;
        $payment->delete();

        $this->updateJamaahStatus($jamaahId);

        return redirect()->back()->with('success', 'Pembayaran berhasil dihapus.');
    }

    // Helper to update jamaah status based on payment total
    private function updateJamaahStatus($jamaahId)
    {
        $jamaah = Jamaah::with(['package', 'payments'])->findOrFail($jamaahId);
        if (! $jamaah->package) {
            return;
        }

        $packagePrice = $this->parsePrice($jamaah->package->price_value);
        $totalPaid = (float) $jamaah->payments->where('status', 'Approved')->sum('amount');

        if ($totalPaid >= $packagePrice) {
            $jamaah->update(['status' => 'Pelunasan']);
        } elseif ($totalPaid > 0) {
            $jamaah->update(['status' => 'DP Masuk']);
        } else {
            $jamaah->update(['status' => 'Prospek']);
        }
    }

    // Helper to parse price string containing formatting to float
    private function parsePrice($rawPrice): float
    {
        if (! $rawPrice) {
            return 0.0;
        }

        $priceNumber = (float) preg_replace('/[^0-9]/', '', $rawPrice);
        if (str_contains(strtolower($rawPrice), 'jt') || str_contains(strtolower($rawPrice), 'juta')) {
            $priceNumber *= 1000000;
        }

        return $priceNumber;
    }

    // Export Invoice PDF
    public function exportInvoice(Payment $payment)
    {
        $payment->load('jamaah.package');

        $pdf = Pdf::loadView('admin.payment.invoice-pdf', compact('payment'));

        return $pdf->download("invoice-pembayaran-{$payment->id}.pdf");
    }
}
