<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MobilImage extends Model {
 protected $table='mobil_images'; protected $fillable=['mobil_id','gambar'];
 public function mobil(){ return $this->belongsTo(Mobil::class); }
}
