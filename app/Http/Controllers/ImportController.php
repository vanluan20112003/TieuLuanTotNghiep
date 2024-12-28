<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class importController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        // Nếu có file được tải lên
        if ($request->isMethod('post')) {
            $request->validate([
                'csv_file' => 'required|file|mimes:csv,txt|max:2048',
            ]);

            // Đọc file CSV trực tiếp
            if ($request->file('csv_file')->isValid()) {
                $file = $request->file('csv_file')->openFile(); // Mở file

                // Đọc từng dòng của file CSV
                while (($line = $file->fgetcsv()) !== FALSE) {
                    $data[] = $line;
                }
            }
        }

        return view('csv', compact('data'));
    }
}
