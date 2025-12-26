<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends Controller
{
    public function testMail()
    {
        $mail = new PHPMailer(true);

        

        try {
            // $mail->isSMTP();
            // $mail->Host       = 'cms1.datacomm.co.id';
           // $mail->SMTPAuth   = true;
           // $mail->Username   = 'sotadmin@emp.id';
            //$mail->Password   = 'S3beningembun';
            //$mail->SMTPSecure = 'ssl'; // coba ganti 'tls' jika error
            //$mail->Port       =  25;   // coba 465 jika gagal
               // 🔎 Debug mode
        $mail->SMTPDebug  = 2;              // level debug (0=off, 1=commands, 2=commands+data)
        $mail->Debugoutput = 'error_log';   // arahkan ke laravel.log (storage/logs)

            $mail->setFrom('eldis@emp.id', 'Admin EMP');
            $mail->addAddress('bayu.indrawan@emp.id', 'Penerima EMP');

           $mail->isHTML(true);
            $mail->Subject = 'Tes Notifikasi';

            $mail->Body    = 'Halo, ini email tes dari Sertifikasi Monitoring Pegawai, Cek web untuk melihat proggres sertifikai yang lebih lanjut.';

            $mail->send();
            return '✅ Pesan berhasil dikirim!';
        } catch (Exception ) {
            return "❌ Pesan gagal: {$mail->ErrorInfo}";
        }
    }
}
