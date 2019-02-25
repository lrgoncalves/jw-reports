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

        $news = [];
        foreach ($trendings as $t) {
            $n = DB::connection('bob')
                ->table('news AS n')
                ->join('publishers AS p', 'n.publisher_id', '=', 'p.id')
                ->join('publisher_medias AS m', 'm.publisher_id', '=', 'p.id')
                ->selectRaw('n.id, n.title, m.id as id_media, m.image_url, m.type, m.image_url, m.label')
                ->where('n.id', $t->id)
                ->whereRaw('m.type = "logo-color2"')
                ->whereRaw('n.active AND n.publisher_id in (' . $in . ')')
                ->first();
            
            if (!$n) {
                continue;
            }

            $news[] = [
                'id' => $n->id,
                'title' => $n->title,
                'total_reads' => $t->total,
                'publisher_media' => $n->image_url,
                'media_publisher' => [
                    'id' => $n->id_media,
                    'type' => $n->type,
                    'content' => $n->image_url,
                ]
            ];

            if (count($news) == 6) {
                break;
            }
        }
        return $news;
    }
}
