<?php

namespace App\Http\Controllers\V2;

use App\Discharges;
use App\Word;
use Illuminate\Http\Request;
use Mockery\Exception;

class ApiController extends Controller
{

    function Words(Request $request)
    {
        $words = new Word();
        if ($request->has('search')) {
            $words = $words->where(function ($query) use ($request) {
                $query->where('title', $request->search);
            });
        }

        $words = $words->orderBy(trim('title'), 'asc')->paginate(20);

        if ($words->count() > 0) {
            $result = array();
            foreach ($words as $word) {
                array_push($result, [
                    "id" => $word->id,
                    "word" => $word->title,
                    "translation" => $word->translation,
                    "definition" => strip_tags($word->definition),
                    "examples" => strip_tags($word->examples)
                ]);

            }

            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Words',
                'result' => $result
            ];
        } else {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Words',
                'result' => 'Word Not Found'
            ];
        }

        return response()->json($response);
    }

    function discharges(Request $request)
    {
        $words = new Discharges();
        if ($request->has('search')) {
            $words = $words->where(function ($query) use ($request) {
                $query->where('pass', 'like', '%' . $request->search . '%')
                    ->orWhere('present', 'like', '%' . $request->search . '%')
                    ->orWhere('future', 'like', '%' . $request->search . '%');
            });
        }

        $words = $words->orderBy(trim('future'), 'asc')->get();

        if ($words->count() > 0) {
            $response = ['status' => true,
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Discharges',
                'result' => $words
            ];
        } else {
            $response = ['status' => true,
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Discharges',
                'result' => 'Discharges Not Found'
            ];
        }

        return response()->json($response);
    }

    function wordById($id)
    {
        $word = Word::where('vocabulary_id', $id)->first();

        if ($word->count() > 0) {
            $response = ['status' => true,
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Word',
                'result' => $word
            ];
        } else {
            $response = ['status' => true,
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Word',
                'result' => 'Word Not Found'
            ];
        }

        return response()->json($response);
    }

    function dischargeByID($id)
    {
        $word = Discharges::where('id', $id)->first();

        if ($word->count() > 0) {
            $response = ['status' => true,
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Word',
                'result' => $word
            ];
        } else {
            $response = ['status' => true,
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Word',
                'result' => 'Word Not Found'
            ];
        }

        return response()->json($response);
    }


}
