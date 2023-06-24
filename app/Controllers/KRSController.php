<?php

namespace App\Controllers;

use App\Repositories\KRSRepository;
use App\Repositories\MahasiswaRepository;

class KRSController extends Controller
{
    private KRSRepository $repo;
    private MahasiswaRepository $mahasiswaRepo;

    public function __construct()
    {
        $this->repo = new KRSRepository();
        $this->mahasiswaRepo = new MahasiswaRepository();
    }

    public function index(): string
    {
        $page = (int)isset($_GET['page']) ? $_GET['page'] : 1;
        $data = $this->repo->paginate(page: $page);
        return $this->view('pages/krs/index', $data);
    }

    public function store(): void
    {
        $mahasiswa = $this->mahasiswaRepo->getByNIM($_POST['nim']);
        if (!$mahasiswa) {
            $_SESSION['error'] = "Mahasiswa dengan NIM {$_POST['nim']} tidak ditemukan.";
            redirect('/krs');
        }

        try {
            $this->repo->insert($_POST['kode'], $_POST['nim'], $_POST['matkul'], $_POST['kelas'], $_POST['sks'],
                $_POST['jadwal'], $_POST['dosen'], $_POST['keterangan']);

            $_SESSION['message'] = "Berhasil menambah data KRS.";
            redirect('/krs');
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function update($kode): void
    {
        $mahasiswa = $this->mahasiswaRepo->getByNIM($_POST['nim']);
        if (!$mahasiswa) {
            $_SESSION['error'] = "Mahasiswa dengan NIM {$_POST['nim']} tidak ditemukan.";
            redirect('/krs');
        }

        $krs = $this->repo->getByKode($kode);
        if (!$krs) {
            $_SESSION['error'] = "KRS dengan Kode {$kode} tidak ditemukan.";
            redirect('/krs');
        }

        try {
            $this->repo->update($kode, $_POST['nim'], $_POST['matkul'], $_POST['kelas'], $_POST['sks'],
                $_POST['jadwal'], $_POST['dosen'], $_POST['keterangan']);

            $_SESSION['message'] = "Berhasil mengubah data KRS.";
            redirect('/krs');
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function delete($kode): void
    {
        $krs = $this->repo->getByKode($kode);
        if (!$krs) {
            $_SESSION['error'] = "KRS dengan Kode {$kode} tidak ditemukan.";
            redirect('/krs');
        }

        try {
            $this->repo->delete($kode);

            $_SESSION['message'] = "Berhasil menghapus data KRS.";
            redirect('/krs');
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }
}