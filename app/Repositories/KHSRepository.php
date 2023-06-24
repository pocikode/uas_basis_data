<?php

namespace App\Repositories;

use App\Repositories\Database as DB;

class KHSRepository
{
    public function insert($kode, $nim, $matkul, $sks, $nilai_mutu, $bobot, $nilai, $keterangan): void
    {
        $query = DB::getInstance()
            ->prepare("INSERT INTO kartu_hasil_studi (kode, nim, mata_kuliah, sks,
                    nilai_mutu, bobot, nilai, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $query->bindParam(1, $kode);
        $query->bindParam(2, $nim);
        $query->bindParam(3, $matkul);
        $query->bindParam(4, $sks);
        $query->bindParam(5, $nilai_mutu);
        $query->bindParam(6, $bobot);
        $query->bindParam(7, $nilai);
        $query->bindParam(8, $keterangan);
        $query->execute();
    }

    public function paginate($page = 1, $limit = 10): array
    {
        $query = DB::getInstance()
            ->query("SELECT count(kode) AS total_khs FROM kartu_hasil_studi")
            ->fetchAll();
        $total_records = $query[0]['total_khs'];

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
            ->query("SELECT * FROM kartu_hasil_studi ORDER BY no DESC LIMIT $offset, $limit")
            ->fetchAll();
    }

    public function getByKode($kode)
    {
        $query = DB::getInstance()->prepare("SELECT * FROM kartu_hasil_studi WHERE kode=? LIMIT 1");
        $query->bindParam(1, $kode);
        $query->execute();

        return $query->fetch();
    }

    public function update($kode, $nim, $matkul, $sks, $nilai_mutu, $bobot, $nilai, $keterangan): int
    {
        $query = DB::getInstance()
            ->prepare("UPDATE kartu_hasil_studi SET nim=?, mata_kuliah=?, sks=?,
                    nilai_mutu=?, bobot=?, nilai=?, keterangan=? WHERE kode=?");

        $query->bindParam(1, $nim);
        $query->bindParam(2, $matkul);
        $query->bindParam(3, $sks);
        $query->bindParam(4, $nilai_mutu);
        $query->bindParam(5, $bobot);
        $query->bindParam(6, $nilai);
        $query->bindParam(7, $keterangan);
        $query->bindParam(8, $kode);
        $query->execute();

        return $query->rowCount();
    }

    public function delete($kode): int
    {
        $query = DB::getInstance()
            ->prepare("DELETE FROM kartu_hasil_studi WHERE kode=?");
        $query->bindParam(1, $kode);
        $query->execute();

        return $query->rowCount();
    }
}