<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokMalaria extends Model
{
    use HasFactory;
    protected $table = 'kelompok_malaria';

    protected $fillable = ['malaria','nama','alamat'];

    public function malaria()
    {
        return $this->belongsTo(Malaria::class, 'malaria', 'id');
    }
}
=======
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokMalaria extends Model
{
    use HasFactory;
    protected $table = 'kelompok_malaria';

    protected $fillable = ['malaria','nama','alamat'];

    public function malaria()
    {
        return $this->belongsTo(Malaria::class, 'malaria', 'id');
    }
}
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
