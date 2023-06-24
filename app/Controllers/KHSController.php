<?php

namespace App\Controllers;

use App\Repositories\KHSRepository;
use App\Repositories\MahasiswaRepository;

class KHSController extends Controller
{
    private KHSRepository $repo;
    private MahasiswaRepository $mahasiswaRepo;

    public function __construct()
    {
        $this->repo = new KHSRepository();
        $this->mahasiswaRepo = new MahasiswaRepository();
    }

    public function index(): string
    {
        $page = (int)isset($_GET['page']) ? $_GET['page'] : 1;
        $data = $this->repo->paginate(page: $page);
        return $this->view('pages/khs/index', $data);
    }

    public function store(): void
    {
        $mahasiswa = $this->mahasiswaRepo->getByNIM($_POST['nim']);
        if (!$mahasiswa) {
            $_SESSION['error'] = "Mahasiswa dengan NIM {$_POST['nim']} tidak ditemukan.";
            redirect('/khs');
        }

        try {
            $this->repo->insert($_POST['kode'], $_POST['nim'], $_POST['matkul'], $_POST['sks'], $_POST['nilai_mutu'],
                $_POST['bobot'], $_POST['nilai'], $_POST['keterangan']);

            $_SESSION['message'] = "Berhasil menambah data Kartu Hasil Studi.";
            redirect('/khs');
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function update($kode): void
    {
        $mahasiswa = $this->mahasiswaRepo->getByNIM($_POST['nim']);
        if (!$mahasiswa) {
            $_SESSION['error'] = "Mahasiswa dengan NIM {$_POST['nim']} tidak ditemukan.";
            redirect('/khs');
        }

        $khs = $this->repo->getByKode($kode);
        if (!$khs) {
            $_SESSION['error'] = "Kartu Hasil Studi dengan Kode {$kode} tidak ditemukan.";
            redirect('/khs');
        }

        try {
            $this->repo->update($kode, $_POST['nim'], $_POST['matkul'], $_POST['sks'], $_POST['nilai_mutu'],
                $_POST['bobot'], $_POST['nilai'], $_POST['keterangan']);

            $_SESSION['message'] = "Berhasil mengubah data Kartu Hasil Studi.";
            redirect('/khs');
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function delete($kode): void
    {
        $khs = $this->repo->getByKode($kode);
        if (!$khs) {
            $_SESSION['error'] = "Kartu Hasil Studi dengan Kode {$kode} tidak ditemukan.";
            redirect('/khs');
        }

        try {
            $this->repo->delete($kode);

            $_SESSION['message'] = "Berhasil menghapus data Kartu Hasil Studi.";
            redirect('/khs');
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }
}