<?php

namespace App\Controllers;

use App\Repositories\MahasiswaRepository;

class MahasiswaController extends Controller
{
    private MahasiswaRepository $repo;

    public function __construct()
    {
        $this->repo = new MahasiswaRepository();
    }

    public function index(): string
    {
        $page = (int)isset($_GET['page']) ? $_GET['page'] : 1;
        $data = $this->repo->paginate(page: $page);
        return $this->view('pages/mahasiswa/index', $data);
    }

    public function store(): void
    {
        try {
            $this->repo->insert($_POST['nim'], $_POST['nama'], $_POST['jenjang'], $_POST['prodi'], $_POST['tahun_masuk'],
                                $_POST['status'], $_POST['semester'], $_POST['sks'], $_POST['ipk']);

            $_SESSION['message'] = "Berhasil menambah data mahasiswa.";
            redirect('/mahasiswa');
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function update($nim): void
    {
        $mahasiswa = $this->repo->getByNIM($nim);
        if (!$mahasiswa) {
            $_SESSION['error'] = "Mahasiswa dengan NIM $nim tidak ditemukan.";
            redirect('/mahasiswa');
        }

        try {
            $this->repo->update($nim, $_POST['nama'], $_POST['jenjang'], $_POST['prodi'], $_POST['tahun_masuk'],
                $_POST['status'], $_POST['semester'], $_POST['sks'], $_POST['ipk']);

            $_SESSION['message'] = "Berhasil update data mahasiswa.";
            redirect('/mahasiswa');
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function delete($nim): void
    {
        $mahasiswa = $this->repo->getByNIM($nim);
        if (!$mahasiswa) {
            $_SESSION['error'] = "Mahasiswa dengan NIM $nim tidak ditemukan.";
            redirect('/mahasiswa');
        }

        try {
            $this->repo->delete($nim);

            $_SESSION['message'] = "Berhasil menghapus data mahasiswa.";
            redirect('/mahasiswa');
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }
}