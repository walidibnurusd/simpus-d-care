<?php

namespace App\Imports;

use App\Models\Patients;
use App\Models\Action;
use App\Models\Diagnosis;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PatientImport implements ToCollection
{
    private function excelSerialToDate($serial)
    {
        // Excel serial date starts from 1900-01-01
        $excelBaseDate = Carbon::createFromFormat('Y-m-d', '1900-01-01');
        // Excel serial date has a 1-based index, so we subtract 2 to get the correct date
        return $excelBaseDate->addDays($serial - 2);
    }

    // Move getFormattedDate method to the class level
    private function getFormattedDate($dateValue)
    {
        if (is_null($dateValue)) {
            return null; // Return null if no data
        }

        if (is_numeric($dateValue)) {
            return $this->excelSerialToDate($dateValue)->format('Y-m-d');
        }

        try {
            return Carbon::createFromFormat('m/d/Y', $dateValue)->format('Y-m-d');
        } catch (\Exception $e) {
            // Handle the exception if the date format is incorrect
            return null;
        }
    }
    public function collection(Collection $rows)
    {
        // dd($rows[3]);
        // Iterate through each row in the collection
        foreach ($rows as $key => $row) {
            // Skip the first row (header)
            if ($key === 0) {
                continue;
            }

            // Filter out empty values from the row (columns with null or empty values will be excluded)
            $filteredRow = array_filter($row->toArray(), function ($value) {
                return $value !== null && $value !== '';
            });

            // Only proceed if there are columns that are not empty
            if (!empty($filteredRow)) {
                // Insert or update patient data
                if (isset($row[4]) && $row[4] !== null && $row[4] !== '') {
                    $dob = $this->getFormattedDate($row[9]);
                    $poli = null;
                    if ($row[11] == 'GIGI') {
                        $poli = 'poli-gigi';
                    } elseif ($row[11] == 'UGD') {
                        $poli = 'ruang-tindakan';
                    } elseif ($row[11] == 'KIA') {
                        $poli = 'poli-kia';
                    } elseif ($row[11] == 'KB') {
                        $poli = 'poli-kb';
                    } elseif ($row[11] == 'UMUM' || $row[11] == 'MTBS') {
                        $poli = 'poli-umum';
                    }
                    $patient = Patients::updateOrCreate(
                        [
                            'nik' => $row[4], // NO. KTP
                        ],
                        [
                            'name' => $row[2] ?? 'Default', // NAMA

                            // Use the parsed date for the 'dob' field
                            'dob' => $dob,

                            'marrital_status' => null,
                            'occupation' => null,
                            'education' => null,
                            'gender' => $row[10] == 'L' ? 2 : ($row[10] == 'P' ? 1 : $row[10]),
                            'no_rm' => $row[1], // NO. RM
                            'address' => $row[5], // ALAMAT
                            'rw' => $row[6], // RW
                            'jenis_kartu' => $row[7], // JENIS KEPESERTAAN
                            'nomor_kartu' => $row[3], // NO. BPJS
                            'klaster' => null, // KUNJUNGAN (LAMA/BARU)
                            'poli' => $poli, // POLI
                        ],
                    );

                    // Find first diagnosis
                    $d1 = Diagnosis::where('icd10', $row[17])->first();

                    // Check if $row[18] is not empty and find the second diagnosis
                    if ($row[18]) {
                        $d2 = Diagnosis::where('icd10', $row[18])->first();
                    } else {
                        $d2 = null; // If no second diagnosis, set $d2 to null
                    }

                    // Check if $d1 and $d2 are not null before accessing their id
                    $d1_id = $d1 ? $d1->id : null;
                    $d2_id = $d2 ? $d2->id : null;

                    // Extract systolic and diastolic values
                    if (strpos($row[20], '/') !== false) {
                        [$sistol, $diastol] = explode('/', $row[20]);
                    } else {
                        // If '/' is not found, set default values or handle the case
                        $sistol = $row[20]; // You could set a default value or leave it as is
                        $diastol = null; // Set diastol to null or a default value
                    }
                    $tanggal = $this->getFormattedDate($row[0]);

                    // Insert action data
                    Action::create([
                        'id_patient' => $patient->id, // Link to the patient ID
                        'tanggal' => $tanggal,
                        'doctor' => $row[30], // NAMA DOKTER
                        'kunjungan' => strtolower($row[8]), // KUNJUNGAN (LAMA/BARU)
                        'faskes' => null, // Tidak ada dalam file Excel
                        'sistol' => $sistol, // Extracted systolic value
                        'diastol' => $diastol, // Extracted diastolic value

                        'lingkarPinggang' => is_numeric($row[24]) ? $row[24] : 0, // If 'nafas' is not numeric, set it to 0
                        'tinggiBadan' => is_numeric($row[22]) ? $row[22] : 0, // If 'nafas' is not numeric, set it to 0
                        'beratBadan' => is_numeric($row[23]) ? $row[23] : 0, // If 'nafas' is not numeric, set it to 0

                        'riwayat_penyakit_sekarang' => null, // KELUHAN
                        'keluhan' => $row[14], // KELUHAN
                        'diagnosa' => array_values(array_filter([$d1_id ? strval($d1_id) : null, $d2_id ? strval($d2_id) : null])),
                        'tindakan' => $row[13], // JENIS TINDAKAN
                        'rujuk_rs' => null, // Tidak ada dalam file Excel
                        'keterangan' => $row[31], // KET
                        'nadi' => is_numeric($row[25]) ? $row[25] : 0, // If 'nafas' is not numeric, set it to 0
                        'nafas' => is_numeric($row[26]) ? $row[26] : 0, // If 'nafas' is not numeric, set it to 0
                        'suhu' => is_numeric($row[21]) ? $row[21] : 0, // Ensure valid numeric input for suhu
                        'hasil_lab' => null, // Tidak ada dalam file Excel
                        'obat' => $row[19], // OBAT
                        'pemeriksaan_penunjang' => null, // Tidak ada dalam file Excel
                        'tipe' => $poli, // Tidak ada dalam file Excel
                        // Tambahkan mapping untuk field lainnya jika ada
                    ]);
                }
            } else {
                // Skip empty rows
                continue;
            }
        }
    }
}
