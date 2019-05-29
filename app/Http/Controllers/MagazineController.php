<?php

namespace App\Http\Controllers;

use App\Models\TimBanca\MagazineFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MagazineController extends Controller
{
    public function getFeatured(Request $request)
    {
        $in = $this->checkArray($request->get('decrypted'), 'magazines');
        // dd($in);
        if (empty($in)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // $in = '78,33,2,77';

        $allowedPublications = explode(',', $in);
        $result = MagazineFeature::
            whereNull('user_id')
            ->whereIn('magazine_id', $allowedPublications)
            ->orderBy('total', 'DESC')
            ->limit(10)
            ->get();
        $arrayMagazines = [];
        foreach ($result as $r) {
            $magazine = DB::connection('bob')
                ->table('publications AS p')
                ->join('editions AS e', 'p.id', '=', 'e.publication_id')
                ->join('publishers AS pp', 'pp.id', '=', 'p.publisher_id')
                ->where('p.id', $r->magazine_id)
                ->whereNull('p.deleted_at')
                ->where('e.is_active', 1)
                ->whereNull('e.deleted_at')
                ->orderBy('e.publication_date', 'DESC')
                ->selectRaw('e.id, e.name, e.publication_id, p.name as publication_name, pp.name as publisher_name, e.description, e.publication_date, e.image_url')
                ->first();

            if (!$magazine) {
                continue;
            }

            // dd($r->magazine_id, $magazine);die;
            $arrayMagazines[] = [
                'id' => $magazine->id,
                'name' => $magazine->name,
                'publication_id' => $magazine->publication_id,
                'publication_name' => $magazine->publication_name,
                'publisher_name' => $magazine->publisher_name,
                'description' => $magazine->description,
                'publication_date' => $magazine->publication_date,
                'image_url' => $magazine->image_url,
            ];
        }
        return $arrayMagazines;
    }
}