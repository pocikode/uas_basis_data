<?php

namespace App\Controllers;

use App\Repositories\KHSRepository;
use App\Repositories\KRSRepository;
use App\Repositories\MahasiswaRepository;

class HomeController extends Controller
{
    private MahasiswaRepository $mahasiswaRepo;
    private KRSRepository $krsRepo;
    private KHSRepository $khsRepo;

    public function __construct()
    {
        $this->mahasiswaRepo = new MahasiswaRepository();
        $this->krsRepo = new KRSRepository();
        $this->khsRepo = new KHSRepository();
    }

    public function index(): string
    {
        return $this->view('pages/home', [
            'total_mahasiswa' => $this->mahasiswaRepo->total_records(),
            'total_krs' => $this->krsRepo->total_records(),
            'total_khs' => $this->khsRepo->total_records(),
        ]);
    }
}