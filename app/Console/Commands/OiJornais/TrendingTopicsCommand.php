<?php

namespace App\Console\Commands\OiJornais;

use App\Models\OiJornais\Event;
use App\Models\NewsTrendingTopic;
use App\Models\Product;
use Illuminate\Console\Command;

class TrendingTopicsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oijornais:trending-topics';

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Importing trending-topics!');

        $trending = Event::getTrendingTopicsNewsIds(30);
        if (is_null($trending) || $trending->count() == 0) {
            return $this->error("Nao foi encontrado nenhuma noticia para o Trending Topics");
        }

        $this->clearTrendingTopics();
        $this->createTrendingTopics($trending);
        $this->info(sprintf("\n\nQue beleza ♪~ ᕕ(ᐛ)ᕗ \n\n %s \n\n", $trending));

    }

     /**
     * limpa os registros atuais
     *
     * @return void
     */
    private function clearTrendingTopics()
    {
        NewsTrendingTopic::where('product_id', '=', Product::OIJORNAIS)->delete();
    }

    /**
     * Cria o snapshot de page_views de trending topics
     *
     * @param collection $trending
     * @return void
     */
    private function createTrendingTopics($trending)
    {
        foreach ($trending as $key => $value) {
            NewsTrendingTopic::create([
                'product_id' => Product::OIJORNAIS,
                'news_id' => $key,
                'total' => $value,
            ]);
        }
    }
}
