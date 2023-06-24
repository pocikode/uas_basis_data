<?php

namespace App\Repositories;

use App\Repositories\Database as DB;

class KRSRepository
{
    public function insert($kode, $nim, $matkul, $kelas, $sks, $jadwal, $dosen, $keterangan): void
    {
        $query = DB::getInstance()
            ->prepare("INSERT INTO kartu_rencana_studi (kode, nim, mata_kuliah, kelas, sks,
                    jadwal, dosen, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $query->bindParam(1, $kode);
        $query->bindParam(2, $nim);
        $query->bindParam(3, $matkul);
        $query->bindParam(4, $kelas);
        $query->bindParam(5, $sks);
        $query->bindParam(6, $jadwal);
        $query->bindParam(7, $dosen);
        $query->bindParam(8, $keterangan);
        $query->execute();
    }

    public function paginate($page = 1, $limit = 10): array
    {
        $total_records = $this->total_records();

        return [
            'page' => $page,
            'total_records' => $total_records,
            'total_pages' => ceil($total_records / $limit),
            'records' => $this->fetch($page, $limit),
        ];
    }

    public function total_records()
    {
        $query = DB::getInstance()
            ->query("SELECT count(kode) AS total_krs FROM kartu_rencana_studi")
            ->fetchAll();

        return $query[0]['total_krs'];
    }

    public function fetch($page = 1, $limit = 10): false|array
    {
        $offset = ($page - 1) * $limit;
        return DB::getInstance()
            ->query("SELECT * FROM kartu_rencana_studi ORDER BY no DESC LIMIT $offset, $limit")
            ->fetchAll();
    }

    public function getByKode($kode)
    {
        $query = DB::getInstance()->prepare("SELECT * FROM kartu_rencana_studi WHERE kode=? LIMIT 1");
        $query->bindParam(1, $kode);
        $query->execute();

        return $query->fetch();
    }

    public function update($kode, $nim, $matkul, $kelas, $sks, $jadwal, $dosen, $keterangan): int
    {
        $query = DB::getInstance()
            ->prepare("UPDATE kartu_rencana_studi SET nim=?, mata_kuliah=?, kelas=?, sks=?,
                    jadwal=?, dosen=?, keterangan=? WHERE kode=?");

        $query->bindParam(1, $nim);
        $query->bindParam(2, $matkul);
        $query->bindParam(3, $kelas);
        $query->bindParam(4, $sks);
        $query->bindParam(5, $jadwal);
        $query->bindParam(6, $dosen);
        $query->bindParam(7, $keterangan);
        $query->bindParam(8, $kode);
        $query->execute();

        return $query->rowCount();
    }

    public function delete($kode): int
    {
        $query = DB::getInstance()
            ->prepare("DELETE FROM kartu_rencana_studi WHERE kode=?");
        $query->bindParam(1, $kode);
        $query->execute();

        return $query->rowCount();
    }
}