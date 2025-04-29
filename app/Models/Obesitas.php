<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obesitas extends Model
{
    use HasFactory;
    protected $table = 'obesitas';

    protected $fillable = ['pasien','hasil', 'tinggi_badan', 'berat_badan', 'lingkar_peru', 'klaster', 'poli','kesimpulan'];
  public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
  
}
=======
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obesitas extends Model
{
    use HasFactory;
    protected $table = 'obesitas';

    protected $fillable = ['pasien','hasil', 'tinggi_badan', 'berat_badan', 'lingkar_peru', 'klaster', 'poli','kesimpulan'];
  public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
  
}
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
