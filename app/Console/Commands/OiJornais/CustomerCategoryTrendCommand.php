<?php

namespace App\Console\Commands\OiJornais;

use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerCategoryTrend;
use App\Models\Event;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CustomerCategoryTrendCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oijornais:customer-category-trend {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command available to import trends categories used by user';

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
        $arguments = $this->arguments();

        $dt = $this->argument('date');
        if (!$dt) {
            $initialDate = Carbon::today();
            $initialDate->setTime($initialDate->offsetHours * -1, 0, 0);

            $endDate = Carbon::tomorrow();
            $endDate->setTime($endDate->offsetHours * -1, 0, 0);
        } else {
            $initialDate = Carbon::createFromFormat('Y-m-d', $dt);
            $initialDate->setTime($initialDate->offsetHours * -1, 0, 0);

            $endDate = Carbon::createFromFormat('Y-m-d', $dt);
            $endDate->setTime($endDate->offsetHours * -1, 0, 0);
            $endDate->addDay(1);
        }

        $this->info(sprintf('Getting news from %s - %s', $initialDate, $endDate));

        $news = Event::where('action', '=', 'news')
            ->where('datetime', '>=', $initialDate)
            ->where('datetime', '<', $endDate)
            ->get();

        $total = $news->count();
        $this->info(sprintf('Total news: %s', $total));

        $array = [];
        foreach ($news as $n) {
            $msisdn = $n['user']['msisdn'];
            $email = $n['user']['email'];

            $customer = Customer::updateOrCreate([
                'product_id' => Product::OIJORNAIS,
                'msisdn' => $msisdn,
            ], [
                'product_id' => Product::OIJORNAIS,
                'msisdn' => $msisdn,
                'email' => $email,
            ]);

            $category = $n['news']['category_name'];

            if (!isset($array[$customer->id])) {
                $array[$customer->id] = [];
            }

            if (!isset($array[$customer->id][$category])) {
                $array[$customer->id][$category] = 1;
            } else {
                $array[$customer->id][$category]++;
            }
        }

        foreach ($array as $customerId => $categories) {

            $this->info(sprintf('Customer: %s', $customerId));
            foreach ($categories as $categoryName => $total) {

                if ($categoryName == '') {
                    $this->info(sprintf('Category not exists: %s', $categoryName));
                    continue;
                }

                $category = Category::updateOrCreate([
                    'name' => $categoryName,
                ], [
                    'name' => $categoryName,
                ]);

                CustomerCategoryTrend::updateOrCreate([
                    'product_id' => Product::OIJORNAIS,
                    'category_id' => $category->id,
                    'customer_id' => $customerId,
                    'date' => $initialDate->format('Y-m-d'),
                ], [
                    'product_id' => Product::OIJORNAIS,
                    'category_id' => $category->id,
                    'customer_id' => $customerId,
                    'date' => $initialDate->format('Y-m-d'),
                    'total' => $total,
                ]);

                $this->info(sprintf('Category %s - %s. Total: %s', $category->id, $categoryName, $total));
            }
        }

    }
}
