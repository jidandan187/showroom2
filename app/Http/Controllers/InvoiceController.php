<?php
namespace App\Http\Controllers;
use App\Models\Transaksi; use Barryvdh\DomPDF\Facade\Pdf;
class InvoiceController extends Controller {
 public function cetak($id){ $q=Transaksi::with('user','detailTransaksi.mobil')->findOrFail($id); abort_unless(auth()->user()->role==='admin' || $q->user_id===auth()->id(),403); return Pdf::loadView('invoice.pdf',['transaksi'=>$q])->download($q->invoice.'.pdf'); }
}
