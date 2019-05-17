<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Mail;

class BaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function info($message, $verbosity = null)
    {
        parent::info(date('Y-m-d H:i:s') . ' - ' . $message, $verbosity);
    }

    public function error($message, $verbosity = null)
    {
        parent::error(date('Y-m-d H:i:s') . ' - ' . $message, $verbosity = null);
    }

    public function sendMailSuccess(string $subject, string $message = '', array $attachments = [])
    {
        $date = Carbon::today();

        Mail::send(
            'emails.batch_mail_success',
            ['title' => $subject, 'text' => $message],
            function ($mail) use ($subject, $date, $attachments) {

                $mail->from('it.processos@bennu.tv');
                $mail->to('suporte@bennu.tv');
                // $mail->to('leandro.rocha@bennu.tv');

                if (env('MAIL_TO_REPORTS')) {
                    $mails = explode(',', env('MAIL_TO_REPORTS'));
                    $mail->cc($mails);
                }

                if (count($attachments)) {
                    foreach ($attachments as $file) {
                        $mail->attach($file, [
                            'as' => basename($file),
                            'mime' => mime_content_type($file),
                        ]);
                    }
                }

                $sub = sprintf('%s - %s - %s', env('APP_NAME'), $subject, $date->format('Y-m-d'));
                $mail->subject($sub);
            }
        );

        return (count(Mail::failures()) === 0);
    }
}
