<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class dataKaryawan extends Controller
{
    private $url = "https://bit.ly/48ejMhW"; // JSON API

    private function parseData()
    {
        $response = Http::get($this->url);
        $json = $response->json();

        // Pecah DATA jadi array
        $rows = explode("\n", trim($json['DATA']));
        $header = explode("|", array_shift($rows));

        $data = array_map(function ($row) use ($header) {
            $cols = explode("|", $row);
            return array_combine($header, $cols);
        }, $rows);

        return collect($data); // supaya bisa where()
    }
    public function getByName(Request $request)
    {
        $name = $request->query('NAMA'); // ambil dari query param
        $data = $this->parseData();

        if (!$name) {
            return response()->json([
                "error" => "Parameter 'nama' wajib diisi"
            ], 400);
        }

        return $data->where('NAMA', $name)->values();
    }

    public function getByNim(Request $request)
    {
        $nim = $request->query('NIM');
        $data = $this->parseData();

        if (!$nim) {
            return response()->json([
                "error" => "Parameter 'nim' wajib diisi"
            ], 400);
        }

        return $data->where('NIM', $nim)->values();
    }

    public function getByYmd(Request $request)
    {
        $ymd = $request->query('YMD');
        $data = $this->parseData();

        if (!$ymd) {
            return response()->json([
                "error" => "Parameter 'ymd' wajib diisi"
            ], 400);
        }

        return $data->where('YMD', $ymd)->values();
    }
}
