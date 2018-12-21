<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\NewsTrendingTopic;
use App\Models\Product;
use Illuminate\Http\Request;

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

        $ids = NewsTrendingTopic::where('product_id', '=', $productId)
            ->orderBy('total', 'DESC')
            ->get()
            ->pluck('news_id');

        $news = [];
        foreach ($ids as $id) {
            $n = Event::getNewsById($id);

            if (!count($n)) {
                continue;
            }

            if (!isset($n[0]->news)) {
                continue;
            }

            if (!isset($n[0]->news->publisherId)) {
                continue;
            }

            if (!in_array($n[0]->news->publisherId, $publishersEnabled)) {
                continue;
            }

            $media = [];
            if ($n[0]->news->mediaPublisher and count($n[0]->news->mediaPublisher)) {
                $media[] = [
                    'id' => $n[0]->news->mediaPublisher[0]->id,
                    'type' => $n[0]->news->mediaPublisher[0]->type,
                    'content' => $n[0]->news->logo,
                ];
            }

            $news[] = [
                'id' => $n[0]->news->id,
                'title' => $n[0]->news->title,
                'publisher_media' => $n[0]->news->logo,
                'media_publisher' => $media
            ];
        }
        return $news;
    }
}
