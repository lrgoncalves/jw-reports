<?php

namespace App\Console\Commands;

use App\Models\OiJornais\EventV2 as EventOiJornais;
use App\Models\TimBanca\EventV2 as EventTimBanca;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Storage;

class AudienceReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:audience {application?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para extrair e enviar relatório de audiência dos projetos Oi Jornais e Tim Banca';

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


        $this->info('Relatórios de Leituras e Downloads');

        $initialDate = (new Carbon('first day of last month'))->setTime(0,0,0);
        $endDate = (new Carbon('last day of last month'))->setTime(0,0,0);

        $this->info(sprintf('Dados do período de %s até %s', $initialDate->format('d/m/Y'), $endDate->format('d/m/Y')));

        // $file1 = $this->totalReads($initialDate, $endDate);

        // $file2 = $this->totalDownloads($initialDate, $endDate);

        // $file3 = $this->totalReadsUU($initialDate, $endDate);

        $file4 = $this->totalDownloadsUU($initialDate, $endDate);

        $this->info('Fim');
    }

    public function totalReads($initialDate, $endDate)
    {

        $this->info('Leituras');

        $magazine_reads = $this->model->getMagazineEventsGroupByPublisherAndPlan($initialDate, $endDate);

        $str = "EDITORA;PLANO;PUBLICACAO;QTD LEITURAS\r\n";
        foreach ($magazine_reads as $ev) {

            if (!isset($ev->_id->plan)) {
                $plan = null;
            } else {
                $plan = $ev->_id->plan;
            }

            if (!isset($ev->_id) || !isset($ev->_id->publisher) || !isset($ev->_id->publication)) {
                continue;
            }

            $publisher = $ev->_id->publisher;
            $publication = $ev->_id->publication;
            $count = $ev->count;

            $str .= "$publisher;$plan;$publication;$count\r\n";

        }

        $newspaper_reads = $this->model->getNewspaperEventsGroupByPublisherAndPlan($initialDate, $endDate);

        // dd($newspaper_reads);

        foreach ($newspaper_reads as $ev) {

            if (!isset($ev->_id->plan)) {
                $plan = null;
            } else {
                $plan = $ev->_id->plan;
            }

            if (!isset($ev->_id) || !isset($ev->_id->publisher)) {
                continue;
            }

            $publisher = $ev->_id->publisher;
            $count = $ev->count;
            $publication = null;

            $str .= "$publisher;$plan;$publication;$count\r\n";

        }

        $fileName = 'leituras.csv';
        if (Storage::disk('local')->put($fileName, $str)) {
            $this->info(sprintf('Arquivo gerado corretamente'));
            return $fileName;
        } else {
            $this->error(sprintf('Problemas ao gerar o arquivo'));
            return false;
        }
    }

    public function totalDownloads($initialDate, $endDate)
    {
        $this->info('Downloads');

        $magazine_downloads = $this->model->getMagazineEventsGroupByPublisherAndPlan($initialDate, $endDate, 'download');

        $str = "EDITORA;PLANO;PUBLICACAO;QTD LEITURAS\r\n";

        foreach ($magazine_downloads as $ev) {

            if (!isset($ev->_id) || !isset($ev->_id->plan) || !isset($ev->_id->publisher) || !isset($ev->_id->publication)) {
                continue;
            }

            $plan = $ev->_id->plan;
            $publisher = $ev->_id->publisher;
            $publication = $ev->_id->publication;
            $count = $ev->count;

            $str .= "$publisher;$plan;$publication;$count\r\n";
        }

        $newspaper_downloads = $this->model->getNewspaperEventsGroupByPublisherAndPlan($initialDate, $endDate, 'download');
        
        foreach ($newspaper_downloads as $ev) {

            if (!isset($ev->_id->plan)) {
                $plan = null;
            } else {
                $plan = $ev->_id->plan;
            }

            if (!isset($ev->_id) || !isset($ev->_id->publisher)) {
                continue;
            }

            $publisher = $ev->_id->publisher;
            $count = $ev->count;
            $publication = null;

            // $str .= "$plan;$publisher;$publication;$count\r\n";
            $str .= "$publisher;$plan;$publication;$count\r\n";
        }

        $fileName = 'downloads.csv';
        if (Storage::disk('local')->put($fileName, $str)) {
            $this->info(sprintf('Arquivo gerado corretamente'));
            return $fileName;
        } else {
            $this->error(sprintf('Problemas ao gerar o arquivo'));
            return false;
        }

    }

    public function totalReadsUU($initialDate, $endDate)
    {

        $this->info('Leituras Usuários Únicos');

        $magazine_reads = $this->model->getMagazineEventsGroupByPublisherAndPlanUU($initialDate, $endDate);

        $str = "EDITORA;PLANO;PUBLICACAO;QTD LEITURAS\r\n";
        foreach ($magazine_reads as $ev) {

            if (!isset($ev->_id->plan)) {
                $plan = null;
            } else {
                $plan = $ev->_id->plan;
            }

            if (!isset($ev->_id) || !isset($ev->_id->publisher) || !isset($ev->_id->publication)) {
                continue;
            }

            $publisher = $ev->_id->publisher;
            $publication = $ev->_id->publication;
            $count = $ev->count;

            $str .= "$publisher;$plan;$publication;$count\r\n";
        }

        $newspaper_reads = $this->model->getNewspaperEventsGroupByPublisherAndPlanUU($initialDate, $endDate);

        foreach ($newspaper_reads as $ev) {

            if (!isset($ev->_id->plan)) {
                $plan = null;
            } else {
                $plan = $ev->_id->plan;
            }

            if (!isset($ev->_id) || !isset($ev->_id->publisher)) {
                continue;
            }

            $publisher = $ev->_id->publisher;
            $publication = null;
            $count = $ev->count;

            $str .= "$publisher;$plan;$publication;$count\r\n";

        }

        $fileName = 'leituras-usuarios-unicos.csv';
        if (Storage::disk('local')->put($fileName, $str)) {
            $this->info(sprintf('Arquivo gerado corretamente'));
            return $fileName;
        } else {
            $this->error(sprintf('Problemas ao gerar o arquivo'));
            return false;
        }
    }

    public function totalDownloadsUU($initialDate, $endDate)
    {
        $this->info('Downloads Usuários Únicos');

        $magazine_downloads = $this->model->getMagazineEventsGroupByPublisherAndPlanUU($initialDate, $endDate, 'download');

        $str = "EDITORA;PLANO;PUBLICACAO;QTD LEITURAS\r\n";
        foreach ($magazine_downloads as $ev) {

            if (!isset($ev->_id) || !isset($ev->_id->plan) || !isset($ev->_id->publisher) || !isset($ev->_id->publication)) {
                continue;
            }

            $plan = $ev->_id->plan;
            $publisher = $ev->_id->publisher;
            $publication = $ev->_id->publication;
            $count = $ev->count;

            $str .= "$publisher;$plan;$publication;$count\r\n";

        }

        $newspaper_downloads = $this->model->getNewspaperEventsGroupByPublisherAndPlanUU($initialDate, $endDate, 'download');
        
        foreach ($newspaper_downloads as $ev) {

            if (!isset($ev->_id->plan)) {
                $plan = null;
            } else {
                $plan = $ev->_id->plan;
            }

            if (!isset($ev->_id) || !isset($ev->_id->publisher)) {
                continue;
            }

            $publisher = $ev->_id->publisher;
            $publication = null;
            $count = $ev->count;

            $str .= "$publisher;$plan;$publication;$count\r\n";

        }


        $fileName = 'downloads-usuarios-unicos.csv';
        if (Storage::disk('local')->put($fileName, $str)) {
            $this->info(sprintf('Arquivo gerado corretamente'));
            return $fileName;
        } else {
            $this->error(sprintf('Problemas ao gerar o arquivo'));
            return false;
        }

    }
}
