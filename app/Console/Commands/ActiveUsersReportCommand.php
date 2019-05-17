<?php

namespace App\Console\Commands;

use App\Models\OiJornais\EventV2 as EventOiJornais;
use App\Models\TimBanca\EventV2 as EventTimBanca;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ActiveUsersReportCommand extends Command
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
        } else {
            $this->model = new EventTimBanca;
        }

        $date = $this->argument('date');
        if (!$date) {
            $endDate = Carbon::yesterday();
        } else {
            $endDate = Carbon::createFromFormat('Y-m-d', $date)->setTime(0, 0, 0);
        }
        $iniDate = clone $endDate;
        $iniDate->subDays(7);

        $this->info(sprintf('Relatórios de Usuários Ativos - Período de %s até %s ', $iniDate->format('Y-m-d'), $endDate->format('Y-m-d')));

        $str = '';
        while ($iniDate <= $endDate) {

            $this->info(sprintf('Obtendo registros do dia %s', $iniDate->format('Y-m-d')));
            $str .= $this->getActives($iniDate);

            $iniDate->addDay(1);
        }

        $this->info($str);
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
