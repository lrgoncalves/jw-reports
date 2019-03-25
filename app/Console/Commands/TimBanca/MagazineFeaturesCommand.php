<?php

namespace App\Console\Commands\TimBanca;

use App\Models\MagazineFeature;
use App\Models\Product;
use App\Models\TimBanca\Event;
use App\Models\TimBanca\MagazineFeature as Feature;
use Illuminate\Console\Command;

class MagazineFeaturesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timbanca:magazine-features';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command available to import the most popular magazines by user';

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
        $this->info('Inicio da importacao ');
        $result = Event::getMagazinesFeatures();
        foreach ($result as  $r) {
            // dd($r);
            if ($r->count == 1) {
                $this->info('Contador chegou a registrar apenas uma leitura. Finaliza.');
                break;
            }


            $this->info('Saving data: ' . $r->_id->user_id . '@' . $r->_id->magazine_id . ':' . $r->count );
            $d = MagazineFeature::updateOrCreate([
                'product_id' => Product::TIMBANCA,
                'user_id' => $r->_id->user_id,
                'magazine_id' => $r->_id->magazine_id,
            ],[
                'product_id' => Product::TIMBANCA,
                'user_id' => $r->_id->user_id,
                'magazine_id' => $r->_id->magazine_id,
                'total' => $r->count
            ]);
        }
        $this->info('fim da importação');
        
        $this->info('Inicio do cálculo de acumulado de leituras');
        $result = MagazineFeature::where('product_id', Product::TIMBANCA)
            ->selectRaw('user_id, sum(total) as total_reads')
            ->groupBy('user_id')
            ->orderBy('total_reads', 'DESC')
            ->get();

        $userId = 0;
        $totalReads = 0;
        foreach ($result as $r) {
            $userId = $r->user_id;
            $totalReads = $r->total_reads;
            $totalAggregated = 0;

            $this->info(sprintf('User: %s; Total: %s', $userId, $totalReads));

            $readUser = $result = MagazineFeature::where('product_id', Product::TIMBANCA)
                ->where('user_id', $userId)
                ->orderBy('total', 'DESC')
                ->get();

            Feature::where('user_id', $userId)->delete();

            foreach ($readUser as $ru) {
                $magazineId = $ru->magazine_id;
                $reads = $ru->total;
                $totalAggregated += $ru->total;

                $percent = round($totalAggregated * 100 / $totalReads);

                if ($percent > 80) {
                    $this->info('80 percent hitted: ' . $magazineId . ':' . $percent);
                    break;
                }

                $this->info(sprintf('%s;%s;%s;%s;%s', $userId, $magazineId, $reads, $totalAggregated, $percent));
                Feature::create([
                    'user_id' => $userId,
                    'magazine_id' => $magazineId,
                    'total' => $reads,
                ]);
            }
            $this->info('Fim do cálculo de acumulado de leituras');
        }
    }
}
