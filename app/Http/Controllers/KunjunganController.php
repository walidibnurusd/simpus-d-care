<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        // Get the filtering dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $kunjungan = Kunjungan::with('patient');

        if ($startDate) {
            $kunjungan->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $kunjungan->whereDate('tanggal', '<=', $endDate);
        }

        $kunjungan = $kunjungan->get();
        // Return the view with the data
        return view('content.kunjungan.index', compact('kunjungan'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the action record to be updated
            $kunjungan = Kunjungan::findOrFail($id);
            // Validate the request
            $validated = $request->validate([
                'poli' => 'nullable',
                'hamil' => 'nullable',
            ]);
            $kunjungan->update([
                'poli' => $validated['poli'] ?? $kunjungan->poli,
                'hamil' => $validated['hamil'] ?? $kunjungan->hamil,
            ]);

            return redirect()->route('kunjungan.index')->with('success', 'Kunjungan Berhasil Diedit');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }
    public function destroy($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->delete();

        // Redirect with a success message
        return redirect()->route('kunjungan.index')->with('success', 'Kunjungan berhasil dihapus');
    }
}
