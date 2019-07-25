<?php

namespace App\Console\Commands;

use App\Models\OiJornais\EventV2 as EventOiJornais;
use App\Models\TimBanca\EventV2 as EventTimBanca;
use App\Models\VivoNews\EventV2 as EventVivoNews;;
use Carbon\Carbon;
use Storage;

class ActiveUsersReportCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:active-users {application?} {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commando para extrair total de usuários únicos dos últimos 30 dias';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $application = ($this->argument('application')) ? $this->argument('application') : 'oijornais';
        if ($application == 'oijornais') {
            $this->model = new EventOiJornais; 
        } else if ($application == 'vivonews') {
            $application = 'vivonews';
            $this->model = new EventVivoNews;
        } else {
            $application = 'timbanca';
            $this->model = new EventTimBanca;
        }

        $date = $this->argument('date');
        if (!$date) {
            $endDate = Carbon::yesterday();
        } else {
            $endDate = Carbon::createFromFormat('Y-m-d', $date)->setTime(0, 0, 0);
        }
        // $iniDate = clone $endDate;
        // $iniDate->subDays(7);
        $iniDate = Carbon::createFromFormat('Y-m-d', '2019-01-01')->setTime(0, 0, 0);

        $fileName = sprintf('%s/usuarios_ativos_nos_ultimos_30_dias.csv', $application);

        $this->info(sprintf('Relatórios de Usuários Ativos - Período de %s até %s ', $iniDate->format('Y-m-d'), $endDate->format('Y-m-d')));

        $str = '';
        while ($iniDate <= $endDate) {

            $this->info(sprintf('Obtendo registros do dia %s', $iniDate->format('Y-m-d')));
            $line = $this->getActives($iniDate);

            if ($line != '') {
                $str .= $line;
            }

            $iniDate->addDay(1);
        }

        if (Storage::disk('s3')->put($fileName, $str)) {
            $this->info(sprintf('Arquivo gerado corretamente'));

            // $attachments = [
            //     storage_path("app/$fileName")
            // ];

            // $result = $this->sendMailSuccess('Relatório de usuários ativos', 'Em anexo', $attachments);
            // if ($result) {
            //     $this->info(sprintf('E-mail enviado com sucesso'));
            // } else {
            //     $this->error(sprintf('ERRO ao enviar o e-mail'));
            // }

            // Storage::delete($fileName);


        } else {
            $this->error(sprintf('Problemas ao gerar o arquivo'));
        }
    }

    private function getActives($endDate) 
    {
        $iniDate = clone $endDate;
        $iniDate->subDays(30);
        // dd($iniDate, $endDate);

        $actives = $this->model->getActiveUsers($iniDate, $endDate);

        if (empty($actives)) {
            $this->info('Resultado não encontrado');
            return false;
        }

        $str = '';
        foreach ($actives as $r) {
            $str .= sprintf(
                "%s;%s;%s\n",
                $endDate->format('Y-m-d'),
                $r->_id->plan,
                $r->count
            );
        }

        return $str;
    }
}
