<?php

namespace App\Http\Controllers;

use App\Models\NewsTrendingTopic;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrendingTopicsController extends Controller
{
    
    public function index(Request $request, $productId = null)
    {

        $in = $this->checkArray($request->get('decrypted'), 'news');
        if (empty($in)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $publishersEnabled = explode(',', $in);

        if (!$productId) {
            $productId = Product::OIJORNAIS;
        }

        $trendings = NewsTrendingTopic::where('product_id', '=', $productId)
            ->orderBy('total', 'DESC')
            ->get();
        // dd($trendings);die;

        $news = [];
        foreach ($trendings as $t) {
            $n = DB::connection('bob')
                ->table('news AS n')
                ->join('publishers AS p', 'n.publisher_id', '=', 'p.id')
                ->join('publisher_medias AS m', 'm.publisher_id', '=', 'p.id')
                ->selectRaw('n.id, n.title, m.id as id_media, m.image_url, m.type, m.image_url, m.label, n.publisher_id, p.name AS publisher_name')
                ->where('n.id', $t->news_id)
                ->whereRaw('m.type = "logo-color2"')
                ->whereRaw('n.active AND n.publisher_id in (' . $in . ')')
                ->first();
                // dd($t);die;

            if (!$n) {
                continue;
            }

            $medias = [];
            $medias[] = [
                'id' => $n->id_media,
                'type' => $n->type,
                'content' => $n->image_url,
            ];

            $news[] = [
                'id' => $n->id,
                'title' => $n->title,
                'publisher_id' => $n->publisher_id,
                'publisher_name' => $n->publisher_name,
                'total_reads' => $t->total,
                'publisher_media' => $n->image_url,
                'media_publisher' => $medias
            ];

            if (count($news) == 6) {
                break;
            }
        }
        
        return $news;
    }
}
