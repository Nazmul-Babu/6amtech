<?php

namespace App\Http\Controllers;

use App\Http\Middleware\BackendAuthCheckMiddleware;
use App\Http\Middleware\IpWhitelistMiddleware;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use SebastianBergmann\Diff\Chunk;

class OperatorController extends Controller
{
    public static function middleware()
    {
        return [
            BackendAuthCheckMiddleware::class . ':operator',
            IpWhitelistMiddleware::class
        ];
    }

    public function approve_post(Request $request)
    {
        dd("Approved");
    }

    public function user_upload()
    {
        $excel_file = 'assets/users.xlsx';
        // File check
        if (file_exists($excel_file)) {
            $spread_sheet = IOFactory::load($excel_file);
            $active_sheet = $spread_sheet->getActiveSheet();
            $highest_row = $active_sheet->getHighestRow();
            $duplicate_emails = [];
            $valid_users = [];
            for ($i = 2; $i <= $highest_row; $i++) {
                $email = $active_sheet->getCell("B" . $i)->getValue();
                $name = $active_sheet->getCell("A" . $i)->getValue();
                $password = $active_sheet->getCell("C" . $i)->getValue();
                $check_unique_email = User::where('email', $email)->count();
                // check unique email 
                if ($check_unique_email < 1) {
                    $valid_users[] = [
                        'name' => $name,
                        'email' => $email,
                        'password' => bcrypt($password),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                } else {
                    $duplicate_emails[] = $email;
                }
                // Check for duplicate emails                   
            }
            if (count($duplicate_emails) < 1) {
                $chunks = array_chunk($valid_users, 1); // here we can assign how much value we want to insert together
                foreach ($chunks as $chunk) {
                    User::insert($chunk);
                }
                dd('Users Uploaded Successfully');
            } else {
                dd('duplicate users',$duplicate_emails);
            }
        }
        return redirect()->back()->with('error', 'File not found.');
    }

}
