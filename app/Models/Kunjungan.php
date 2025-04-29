<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;
    protected $table = 'kunjungan';

    protected $fillable = ['pasien','poli','hamil','tanggal'];
  public function patient()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
  
}
=======
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;
    protected $table = 'kunjungan';

    protected $fillable = ['pasien','poli','hamil','tanggal'];
  public function patient()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
  
}
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
