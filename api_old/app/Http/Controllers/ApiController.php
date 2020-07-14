<?php

namespace App\Http\Controllers;

use App\Discharges;
use App\Idioms;
use App\Job;
use App\Medical;
use App\Shortcut;
use App\Slang;
use App\Format;
use App\User;
use App\Word;
use App\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class ApiController extends Controller
{
    /*
     * Version 1
        function words(Request $request)
        {
            $words = new Word();
            if ($request->has('search')) {
                $words = $words->where(function ($query) use ($request) {
                    $query->where('vocabulary_word', $request->search);
                });
            }

            $words = $words->orderBy(trim('vocabulary_word'), 'asc')->get();

            if ($words->count() > 0) {
                $result=array();
                foreach($words as $word){
                array_push($result,[
                "vocabulary_id"=>$word->vocabulary_id,
                "vocabulary_word"=> $word->vocabulary_word,
                "vocabulary_translation"=>$word->vocabulary_translation,
                "vocabulary_definition"=>strip_tags($word->vocabulary_definition),
                "vocabulary_examples"=>strip_tags($word->vocabulary_examples)
                    ]);

                }

                $response = ['status' => true,
                    'message' => 'welcome to moofradat.com Api. by iFeras93',
                    'request' => 'Words',
                    'result' => $result
                ];
            } else {
                $response = ['status' => true,
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

      function wordById($id){
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

      function dischargeByID($id){
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
      }*/

    private $email;
    private $name;
    private $subject;

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
                $added_by = '';
                $added_by_id = '';
                if ($word->added_by != null) {
                    $user = User::where('id', $word->added_by)->first();
                    $added_by = $user->username;
                    $added_by_id = $user->id;
                } else {
                    $added_by = '@moofradat';
                    $added_by_id = 10;
                }

                array_push($result, [
                    "id" => $word->id,
                    "word" => $word->title,
                    "translation" => $word->translation,
                    "definition" => strip_tags($word->definition),
                    "examples" => strip_tags(trim($word->examples)),
                    'added_by' => 'تمت من قبل ' . $added_by,
                    'added_by_id' => $added_by_id,
                ]);

            }

            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Words',
                'pagination_info' => [
                    'next_page' => $words->nextPageUrl(),
                    'previous_page' => $words->previousPageUrl(),
                    'total_words' => $words->total(),
                    "per_page" => $words->perPage(),
                    "current_page" => $words->currentPage(),
                ],
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


    function Discharges(Request $request)
    {
        $words = new Discharges();
        if ($request->has('search')) {
            $words = $words->where(function ($query) use ($request) {
                $query->where('en_past', $request->search)
                    ->orWhere('en_present', $request->search)
                    ->orWhere('en_future', $request->search);
            });
        }
        $words = $words->orderBy(trim('en_future'), 'asc')->paginate(20);

        if ($words->count() > 0) {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Discharges',
                'result' => $words
            ];
        } else {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Discharges',
                'result' => 'Discharges Not Found'
            ];
        }

        return response()->json($response);
    }


    function Slang(Request $request)
    {
        $words = new Slang();
        if ($request->has('search')) {
            $words = $words->where(function ($query) use ($request) {

                $query->where('sentence', $request->search);

            });
        }

        $words = $words->orderBy(trim('sentence'), 'asc')->paginate(20);

        if ($words->count() > 0) {
            $result = array();
            foreach ($words as $word) {

                if ($word->added_by != null) {
                    $user = User::where('id', $word->added_by)->first();
                    $added_by = $user->username;
                    $added_by_id = $user->id;

                } else {
                    $added_by = '@moofradat';
                    $added_by_id = 10;
                }

                array_push($result, [
                    "id" => $word->id,
                    "sentence" => strip_tags($word->sentence),
                    "translation" => strip_tags($word->translation),
                    'added_by' => 'تمت من قبل ' . $added_by,
                    'added_by_id' => $added_by_id,
                ]);

            }

            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Slang',
                'pagination_info' => [
                    'next_page' => $words->nextPageUrl(),
                    'previous_page' => $words->previousPageUrl(),
                    'total_words' => $words->total(),
                    "per_page" => $words->perPage(),
                    "current_page" => $words->currentPage(),
                ],
                'result' => $result
            ];
        } else {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Slang',
                'result' => 'Slang Not Found'
            ];
        }

        return response()->json($response);
    }


    function Shortcuts(Request $request)
    {
        $words = new Shortcut();
        if ($request->has('search')) {
            $words = $words->where(function ($query) use ($request) {
                $query->where('shortcut', $request->search)
                    ->orWhere('mean', $request->search);
            });
        }

        $words = $words->orderBy(trim('shortcut'), 'asc')->paginate(20);

        if ($words->count() > 0) {
            $result = array();
            foreach ($words as $word) {

                if ($word->added_by != null) {
                    $user = User::where('id', $word->added_by)->first();
                    $added_by = $user->username;
                    $added_by_id = $user->id;

                } else {
                    $added_by = "@moofradat";
                    $added_by_id = 10;
                }


                array_push($result, [
                    "id" => $word->id,
                    "shortcut" => $word->shortcut,
                    "mean" => $word->mean,
                    "translation" => strip_tags($word->translation),
                    'added_by' => 'تمت من قبل ' . $added_by,
                    'added_by_id' => $added_by_id,
                ]);
            }

            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Shortcuts',
                'pagination_info' => [
                    'next_page' => $words->nextPageUrl(),
                    'previous_page' => $words->previousPageUrl(),
                    'total_words' => $words->total(),
                    "per_page" => $words->perPage(),
                    "current_page" => $words->currentPage(),
                ],
                'result' => $result
            ];
        } else {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Shortcuts',
                'result' => 'Shortcuts Not Found'
            ];
        }

        return response()->json($response);
    }


    function Medical(Request $request)
    {
        $words = new Medical();
        if ($request->has('search')) {
            $words = $words->where(function ($query) use ($request) {
                $query->where('title', $request->search);
            });
        }

        $words = $words->orderBy(trim('title'), 'asc')->paginate(20);

        if ($words->count() > 0) {
            $result = array();
            foreach ($words as $word) {
                if ($word->added_by != null) {
                    $user = User::where('id', $word->added_by)->first();
                    $added_by = $user->username;
                    $added_by_id = $user->id;

                } else {
                    $added_by = '@moofradat';
                    $added_by_id = 10;
                }
                array_push($result, [
                    "id" => $word->id,
                    "title" => $word->title,
                    "translation" => $word->translation,
                    "example" => strip_tags(str_replace('&nbsp;', ' ', $word->example)),
                    'added_by' => 'تمت من قبل ' . $added_by,
                    'added_by_id' => $added_by_id,
                ]);
            }

            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Medical',
                'pagination_info' => [
                    'next_page' => $words->nextPageUrl(),
                    'previous_page' => $words->previousPageUrl(),
                    'total_words' => $words->total(),
                    "per_page" => $words->perPage(),
                    "current_page" => $words->currentPage(),
                ],
                'result' => $result
            ];
        } else {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Medical',
                'result' => 'Medical Terms Not Found'
            ];
        }

        return response()->json($response);
    }

    function Jobs(Request $request)
    {
        $jobs = new Job();
        if ($request->has('search')) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->where('title', $request->search);
            });
        }

        $jobs = $jobs->orderBy(trim('title'), 'asc')->get();

        if ($jobs->count() > 0) {

            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Jobs',
                'result' => $jobs
            ];
        } else {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Jobs',
                'result' => 'Job Not Found'
            ];
        }

        return response()->json($response);
    }


    function Formats(Request $request)
    {
        $words = new Format();
        if ($request->has('search')) {
            $words = $words->where(function ($query) use ($request) {
                $query->where('noun', $request->search)
                    ->orWhere('verb', $request->search)
                    ->orWhere('adjective', $request->search)
                    ->orWhere('adverb', $request->search);
            });
        }

        $words = $words->orderBy(trim('noun'), 'asc')->paginate(20);

        if ($words->count() > 0) {
            $result = array();
            foreach ($words as $word) {

                if ($word->added_by != null) {
                    $user = User::where('id', $word->added_by)->first();
                    $added_by = $user->username;
                    $added_by_id = $user->id;

                } else {
                    $added_by = '@moofradat';
                    $added_by_id = 10;
                }


                array_push($result, [
                    "id" => $word->id,
                    "noun" => $word->noun,
                    "verb" => $word->verb,
                    "adjective" => $word->adjective,
                    "adverb" => $word->adverb,
                    'added_by' => 'تمت من قبل ' . $added_by,
                    'added_by_id' => $added_by_id,
                ]);
            }

            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Words Format',
                'pagination_info' => [
                    'next_page' => $words->nextPageUrl(),
                    'previous_page' => $words->previousPageUrl(),
                    'total_words' => $words->total(),
                    "per_page" => $words->perPage(),
                    "current_page" => $words->currentPage(),
                ],
                'result' => $result
            ];
        } else {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Words Format',
                'result' => 'Format Not Found'
            ];
        }

        return response()->json($response);
    }


    function Idioms(Request $request)
    {
        $idioms = new Idioms();
        if ($request->has('search')) {
            $idioms = $idioms->where(function ($query) use ($request) {
                //$query->where('title', $request->search);
                $query->where('title', $request->search);
            });
        }

        $idioms = $idioms->orderBy(trim('title'), 'asc')->paginate(20);

        if ($idioms->count() > 0) {
            $result = array();
            foreach ($idioms as $idiom) {
                if ($idiom->added_by != null) {
                    $user = User::where('id', $idiom->added_by)->first();
                    $added_by = $user->username;
                    $added_by_id = $user->id;

                } else {
                    $added_by = "@moofradat";
                    $added_by_id = 10;
                }

                array_push($result, [
                    "id" => $idiom->id,
                    "word" => $idiom->title,
                    "translation" => $idiom->translation,
                    "definition" => strip_tags($idiom->explain),
                    "examples" => strip_tags(trim($idiom->example)),
                    'added_by' => 'تمت من قبل ' . $added_by,
                    'added_by_id' => $added_by_id,
                ]);

            }

            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Idioms',
                'pagination_info' => [
                    'next_page' => $idioms->nextPageUrl(),
                    'previous_page' => $idioms->previousPageUrl(),
                    'total_words' => $idioms->total(),
                    "per_page" => $idioms->perPage(),
                    "current_page" => $idioms->currentPage(),
                ],
                'result' => $result
            ];
        } else {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Idioms',
                'result' => 'Idioms Not Found'
            ];
        }

        return response()->json($response);
    }


    function Ads()
    {
        $ads = new Ads();


        $ads = $ads->get();

        if ($ads->count() > 0) {

            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Ads',
                'result' => $ads
            ];
        } else {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Ads',
                'result' => 'Ads Not Found'
            ];
        }

        return response()->json($response);
    }


    /* Get By ID */
    function wordById($id)
    {
        $word = Word::where('id', $id)->first();

        if ($word) {
            $result = [
                "id" => $word->id,
                "word" => $word->title,
                "translation" => $word->translation,
                "definition" => strip_tags(str_replace('&nbsp;', ' ', $word->definition)),
                "examples" => strip_tags(str_replace('&nbsp;', ' ', $word->examples))
            ];
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


    function dischargesById($id)
    {
        $word = Discharges::where('id', $id)->first();

        if ($word) {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Discharges',
                'result' => $word
            ];
        } else {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Discharges',
                'result' => 'Discharges Not Found'
            ];
        }

        return response()->json($response);
    }


    function slangById($id)
    {
        $word = Slang::where('id', $id)->first();

        if ($word) {
            $result = [
                "id" => $word->id,
                "sentence" => strip_tags($word->sentence),
                "translation" => strip_tags($word->translation),
            ];

            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Slang',
                'result' => $result
            ];
        } else {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Slang',
                'result' => 'Slang Not Found'
            ];
        }

        return response()->json($response);
    }


    function shortutsById($id)
    {
        $word = Shortcut::where('id', $id)->first();

        if ($word) {
            $result = [
                "id" => $word->id,
                "shortcut" => $word->shortcut,
                "mean" => $word->mean,
                "translation" => strip_tags($word->translation),
            ];

            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Shortcuts',
                'result' => $result
            ];
        } else {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Shortcuts',
                'result' => 'Shortcuts Not Found'
            ];
        }

        return response()->json($response);
    }


    function medicalById($id)
    {
        $word = Medical::where('id', $id)->first();


        if ($word) {
            $result = [
                "id" => $word->id,
                "title" => $word->title,
                "translation" => $word->translation,
                "example" => strip_tags(str_replace('&nbsp;', ' ', $word->example)),
            ];

            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Medical',
                'result' => $result
            ];
        } else {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Medical',
                'result' => 'Medical Terms Not Found'
            ];
        }

        return response()->json($response);
    }

    function formatsById($id)
    {
        $word = Format::where('id', $id)->first();

        if ($word) {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Formats',
                'result' => $word
            ];
        } else {
            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Formats',
                'result' => 'Formats Not Found'
            ];
        }

        return response()->json($response);
    }


    public function sendEmail(Request $request)
    {
        try {

            $content = $request->input('content');
            /* $this->email = $request->input('email');
             $this->name = $request->input('name');
             $this->subject = $request->input('subject');*/
            $content .= "\n sender: " . $request->input('name') . "\n Email: " . $request->input('email');
            Mail::raw($content, function ($msg) use ($request) {
                $msg->to(['contactus@moofradat.com']);
                $msg->from($request->input('email'), $request->input('name'));
                $msg->subject($request->input('subject'));
            });
            return response()->json(['status', true]);
        } catch (Exception $exception) {
            return response()->json(['status', false]);
        }
    }

    public function translateRequest(Request $request)
    {
        try {

            $content = $request->input('content');
            /* $this->email = $request->input('email');
             $this->name = $request->input('name');
             $this->subject = $request->input('subject');*/
            $content .= "\n sender: " . $request->input('name') . "\n Email: " . $request->input('email');
            Mail::raw($content, function ($msg) use ($request) {
                $msg->to(['translate@moofradat.com']);
                $msg->from($request->input('email'), $request->input('name'));
                $msg->subject('طلب ترجمة جديد');
            });
            return response()->json(['status', true]);
        } catch (Exception $exception) {
            return response()->json(['status', false]);
        }
    }

    public function jobRequest(Request $request)
    {
        try {

            $content = $request->input('content');
            /* $this->email = $request->input('email');
             $this->name = $request->input('name');
             $this->subject = $request->input('subject');*/
            $content .= "\n sender: " . $request->input('name') . "\n Email: " . $request->input('email');

            Mail::raw($content, function ($msg) use ($request) {
                $msg->to(['jobs@moofradat.com']);
                $msg->from($request->input('email'), $request->input('name'));
                $msg->subject('تقديم لوظيفة ' . $request->input('job'));
            });
            return response()->json(['status', true]);
        } catch (Exception $exception) {
            return response()->json(['status', false]);
        }
    }


    function all(Request $request)
    {
        $words = new Word();
        $discharges = new Discharges();
        $shortcuts = new Shortcut();
        $slang = new Slang();
        $terms = new Medical();
        $formats = new Format();
        $idioms = new Idioms();

        if ($request->has('search')) {

            $words = $words->where(function ($query) use ($request) {
                $query->where('title', $request->search);
                /*$query->orWhere('translation', 'like', '%' . $request->search . '%');*/
            })->orderBy('title', 'asc')->get();
            $discharges = $discharges->where(function ($query) use ($request) {
                $query->where('en_past', $request->search);
                $query->orWhere('en_present', $request->search);
                $query->orWhere('en_future', $request->search . '%');
            })->orderBy('en_future', 'asc')->get();
            $shortcuts = $shortcuts->where(function ($query) use ($request) {
                $query->where('shortcut', $request->search);
                $query->orWhere('mean', $request->search);
                /*$query->orWhere('translation', 'like', $request->search);*/
            })->orderBy('shortcut', 'asc')->get();

            $slang = $slang->where(function ($query) use ($request) {
                $query->where('sentence', $request->search);
                /*$query->orWhere('translation', 'like', $request->search);*/
            })->orderBy('sentence', 'asc')->get();
            $terms = $terms->where(function ($query) use ($request) {
                $query->where('title', $request->search);
                /*$query->orWhere('translation', 'like', $request->search);*/
            })->orderBy('title', 'asc')->get();
            $formats = $formats->where(function ($query) use ($request) {
                $query->where('noun', $request->search);
                $query->orwhere('verb', $request->search);
                $query->orwhere('adjective', $request->search);
                $query->orwhere('adverb', $request->search);
            })->orderBy('noun', 'asc')->get();
            $idioms = $idioms->where(function ($query) use ($request) {
                $query->where('title', $request->search);
            })->orderBy('title', 'asc')->get();

            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Search At All',
                'result' => [
                    'Words' => $words,
                    'Discharges' => $discharges,
                    "Slang" => $slang,
                    "Shortcuts" => $shortcuts,
                    "Medical" => $terms,
                    "Formats" => $formats,
                    "Idioms" => $idioms
                ]
            ];

            return response()->json($response);
        } else {

            $response = [
                'message' => 'welcome to moofradat.com Api. by iFeras93',
                'request' => 'Search At All',
                'result' => 'Nothing'
            ];

            return response()->json($response);

        }


    }
}
