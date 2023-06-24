<?php

namespace App\Repositories;

use App\Repositories\Database as DB;

class MahasiswaRepository
{
    public function insert($nim, $nama, $jenjang, $prodi, $tahun_masuk, $status, $semester, $sks, $ipk): void
    {
        $query = DB::getInstance()
            ->prepare("INSERT INTO mahasiswa (nim, nama, jenjang, program_studi, tahun_masuk,
                    status, semester, sks, ipk) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $query->bindParam(1, $nim);
        $query->bindParam(2, $nama);
        $query->bindParam(3, $jenjang);
        $query->bindParam(4, $prodi);
        $query->bindParam(5, $tahun_masuk);
        $query->bindParam(6, $status);
        $query->bindParam(7, $semester);
        $query->bindParam(8, $sks);
        $query->bindParam(9, $ipk);
        $query->execute();
    }

    public function paginate($page = 1, $limit = 10): array
    {
        $query = DB::getInstance()
            ->query("SELECT count(nim) AS total_nim FROM mahasiswa")
            ->fetchAll();
        $total_records = $query[0]['total_nim'];

        return [
            'page' => $page,
            'total_records' => $total_records,
            'total_pages' => ceil($total_records / $limit),
            'records' => $this->fetch($page, $limit),
        ];
    }

    public function fetch($page = 1, $limit = 10): false|array
    {
        $offset = ($page - 1) * $limit;
        return DB::getInstance()
            ->query("SELECT * FROM mahasiswa ORDER BY id DESC LIMIT $offset, $limit")
            ->fetchAll();
    }

    public function getByNIM($nim)
    {
        $query = DB::getInstance()->prepare("SELECT * FROM mahasiswa WHERE nim=? LIMIT 1");
        $query->bindParam(1, $nim);
        $query->execute();

        return $query->fetch();
    }

    public function update($nim, $nama, $jenjang, $prodi, $tahun_masuk, $status, $semester, $sks, $ipk): int
    {
        $query = DB::getInstance()
            ->prepare("UPDATE mahasiswa SET nama=?, jenjang=?, program_studi=?, tahun_masuk=?,
                    status=?, semester=?, sks=?, ipk=? WHERE nim=?");

        $query->bindParam(1, $nama);
        $query->bindParam(2, $jenjang);
        $query->bindParam(3, $prodi);
        $query->bindParam(4, $tahun_masuk);
        $query->bindParam(5, $status);
        $query->bindParam(6, $semester);
        $query->bindParam(7, $sks);
        $query->bindParam(8, $ipk);
        $query->bindParam(9, $nim);
        $query->execute();

        return $query->rowCount();
    }

    public function delete($nim): int
    {
        $query = DB::getInstance()
            ->prepare("DELETE FROM mahasiswa WHERE nim=?");
        $query->bindParam(1, $nim);
        $query->execute();

        return $query->rowCount();
    }
}