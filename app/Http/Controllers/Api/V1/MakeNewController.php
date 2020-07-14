<?php

namespace App\Http\Controllers\Api\V1;

use App\Discharges;
use App\Format;
use App\Http\Controllers\Controller;
use App\Idioms;
use App\Medical;
use App\Shortcut;
use App\Slang;
use App\User;
use App\Word;
use Illuminate\Http\Request;
use Validator;

class MakeNewController extends Controller
{
    private $response = [];


    public function storeNewWord(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'translation' => 'required',
                'definition' => 'required',
                'examples' => 'required',
            ], [
                'title.required' => 'حقل الكلمة إجباري',
                'translation.required' => 'حقل الترجمة إجباري',
                'definition.required' => 'حقل التعريف إجباري',
                'examples.required' => 'حقل الأمثلة إجباري',
            ]);

            if ($validator->fails()) {
                $this->response = [
                    'status' => false,
                    'message' => 'خطأ',
                    'result' => $validator->errors()->first()
                ];
                return response()->json($this->response);
            } else {
                $word = new Word();
                $word->title = $request->input('title');
                $word->translation = $request->input('translation');
                $word->definition = $request->input('definition');
                $word->examples = $request->input('examples');
                $word->added_by = auth()->user()->id;
                $word->created_at = time();
                $user = auth()->user();
                
                if ($user->roles[0]->id == 3)
                    $word->status = 0;
                else
                    $word->status = 1;

                if (!$word->save()) {
                    $this->response = [
                        'status' => false,
                        'message' => 'خطأ',
                        'result' => 'خطأ في الإضافة'
                    ];
                    return response()->json($this->response);
                }
                if($word->status == 0) {
                    $word['status'] = "قيد الانتظار";
                }
                elseif($word->status == 1) {
                    $word['status'] = "مقبولة";
                }
                else {
                    $word['status'] = "مرفوضة";
                }
                $this->response = [
                    'status' => $word,
                    'message' => 'تم بنجاح',
                    'result' => 'تمت الإضافة بنجاح'
                ];
                return response()->json($this->response);
            }

        }
    }
    
    

    public function storeNewSlang(Request $request)
    {
        //

        
            $validator = Validator::make($request->all(), [
                'sentence' => 'required',
                'translation' => 'required',
            ], [
                'sentence.required' => 'حقل الكلمة إجباري',
                'translation.required' => 'حقل الترجمة إجباري',
            ]);

            if ($validator->fails()) {

                $this->response = [
                    'status' => false,
                    'message' => 'خطأ',
                    'result' => $validator->errors()->first()
                ];
                return response()->json($this->response);

            } else {
                $slang = new Slang();
                $slang->sentence = $request->input('sentence');
                $slang->translation = $request->input('translation');
                $slang->added_by = auth('api')->user()->id;
                $slang->created_at = time();
                $user = User::where('id', auth('api')->user()->id)->first();
                if ($user->roles[0]->id == 3)
                    $slang->status = 0;
                else
                    $slang->status = 1;

                if (!$slang->save()) {
                    $this->response = [
                        'status' => false,
                        'message' => 'خطأ',
                        'result' => 'خطأ في الإضافة'
                    ];
                    return response()->json($this->response);
                }

                $this->response = [
                    'status' => true,
                    'message' => 'تم بنجاح',
                    'result' => 'تمت الإضافة بنجاح'
                ];
                return response()->json($this->response);
            }

        

    }


    public function storeNewShortcuts(Request $request)
    {
        //

            $validator = Validator::make($request->all(), [
                'shortcut' => 'required',
                'mean' => 'required',
                'translation' => 'required',
            ], [
                'shortcut.required' => 'حقل الإختصار إجباري',
                'mean.required' => 'حقل الإختصار كامل إجباري',
                'translation.required' => 'حقل الترجمة إجباري',
            ]);

            if ($validator->fails()) {

                $this->response = [
                    'status' => false,
                    'message' => 'خطأ',
                    'result' => $validator->errors()->first()
                ];
                return response()->json($this->response);
            } else {
                $shortcut = new Shortcut();
                $shortcut->shortcut = $request->input('shortcut');
                $shortcut->mean = $request->input('mean');
                $shortcut->translation = $request->input('translation');
                $shortcut->added_by = auth('api')->user()->id;
                $user = User::where('id', auth('api')->user()->id)->first();
                if ($user->roles[0]->id == 3)
                    $shortcut->status = 0;
                else
                    $shortcut->status = 1;


                if (!$shortcut->save()) {

                    $this->response = [
                        'status' => false,
                        'message' => 'خطأ',
                        'result' => 'خطأ في الإضافة'
                    ];
                    return response()->json($this->response);
                }

                $this->response = [
                    'status' => true,
                    'message' => 'تم بنجاح',
                    'result' => 'تمت الإضافة بنجاح'
                ];
                return response()->json($this->response);
            }

        
    }


    public function storeNewMedical(Request $request)
    {
        //
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'translation' => 'required',
                'example' => 'required',
            ], [
                'title.required' => 'حقل الكلمة إجباري',
                'translation.required' => 'حقل الترجمة إجباري',
                'example.required' => 'حقل الأمثلة إجباري',
            ]);

            if ($validator->fails()) {

                $this->response = [
                    'status' => false,
                    'message' => 'خطأ',
                    'result' => $validator->errors()->first()
                ];
                return response()->json($this->response);
            } else {
                $term = new Medical();
                $term->title = $request->input('title');
                $term->translation = $request->input('translation');
                $term->example = $request->input('example');
                $term->added_by = auth('api')->user()->id;


                $user = User::where('id', auth('api')->user()->id)->first();
                if ($user->roles[0]->id == 3)
                    $term->status = 0;
                else
                    $term->status = 1;


                if (!$term->save()) {
                    $this->response = [
                        'status' => false,
                        'message' => 'خطأ',
                        'result' => 'خطأ في الإضافة'
                    ];
                    return response()->json($this->response);
                }

                $this->response = [
                    'status' => true,
                    'message' => 'تم بنجاح',
                    'result' => 'تمت الإضافة بنجاح'
                ];
                return response()->json($this->response);
            }

        }
    }


    public function storeNewIdioms(Request $request)
    {
        //
        
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'explain' => 'required',
                'translation' => 'required',
                'example' => 'required',
            ], [
                'title.required' => 'حقل الكلمة إجباري',
                'explain.required' => 'حقل الشرح إجباري.',
                'translation.required' => 'حقل الرجمة إجباري',
                'example.required' => 'حقل المثال إجباري',
            ]);

            if ($validator->fails()) {
                $this->response = [
                    'status' => false,
                    'message' => 'خطأ',
                    'result' => $validator->errors()->first()
                ];
                return response()->json($this->response);
            } else {
                $idioms = new Idioms();
                $idioms->title = $request->input('title');
                $idioms->explain = $request->input('explain');
                $idioms->translation = $request->input('translation');
                $idioms->example = $request->input('example');
                $idioms->added_by = auth('api')->user()->id;
                $user = User::where('id', auth('api')->user()->id)->first();
                if ($user->roles[0]->id == 3)
                    $idioms->status = 0;
                else
                    $idioms->status = 1;


                if (!$idioms->save()) {
                    $this->response = [
                        'status' => false,
                        'message' => 'خطأ',
                        'result' => 'خطأ في الإضافة'
                    ];
                    return response()->json($this->response);
                }

                $this->response = [
                    'status' => true,
                    'message' => 'تم بنجاح',
                    'result' => 'تمت الإضافة بنجاح'
                ];
                return response()->json($this->response);
            }

        
    }


    public function storeNewFormat(Request $request)
    {
        //
 
            $validator = Validator::make($request->all(), [
                'noun' => 'required|min:1',
                'verb' => 'required|min:1',
                'adjective' => 'required|min:1',
                'adverb' => 'required|min:1',
            ], [
                'noun.required' => 'حقل الإسم إجباري',
                'verb.required' => 'حقل الفعل إجباري',
                'adjective.required' => 'حقل الصفة إجباري',
                'adverb.required' => 'حقل الحال إجباري',
                'noun.min' => 'حقل الإسم قصير جداً.',
                'verb.min' => 'حقل الإسم قصير جداً.',
                'adjective.min' => 'حقل الإسم قصير جداً.',
                'adverb.min' => 'حقل الإسم قصير جداً.',
            ]);

            if ($validator->fails()) {

                $this->response = [
                    'status' => false,
                    'message' => 'خطأ',
                    'result' => $validator->errors()->first()
                ];
                return response()->json($this->response);

            } else {
                $format = new Format();
                $format->noun = $request->input('noun');
                $format->verb = $request->input('verb');
                $format->adjective = $request->input('adjective');
                $format->adverb = $request->input('adverb');
                $format->added_by = auth('api')->user()->id;
                $user = User::where('id', auth('api')->user()->id)->first();
                if ($user->roles[0]->id == 3)
                    $format->status = 0;
                else
                    $format->status = 1;

                if (!$format->save()) {
                    $this->response = [
                        'status' => false,
                        'message' => 'خطأ',
                        'result' => 'خطأ في الإضافة'
                    ];
                    return response()->json($this->response);
                }

                $this->response = [
                    'status' => true,
                    'message' => 'تم بنجاح',
                    'result' => 'تمت الإضافة بنجاح'
                ];
                return response()->json($this->response);
            }

        
    }


    public function storeNewDischarges(Request $request)
    {
        //


            $validator = Validator::make($request->all(), [
                'en_past' => 'required',
                'en_present' => 'required',
                'en_future' => 'required',

            ], [
                'en_past.required' => 'حقل التصريف الاول إجباري',
                'en_present.required' => 'حقل التصريف الثاني إجباري',
                'en_future.required' => 'حقل التصريف الثالث إجباري',
            ]);

            if ($validator->fails()) {

                $this->response = [
                    'status' => false,
                    'message' => 'خطأ',
                    'result' => $validator->errors()->first()
                ];
                return response()->json($this->response);

            } else {
                $discharges = new Discharges();
                $discharges->en_past = $request->input('en_past');
                $discharges->ar_past = $request->input('ar_past');
                $discharges->en_present = $request->input('en_present');
                $discharges->ar_present = $request->input('ar_present');
                $discharges->en_future = $request->input('en_future');
                $discharges->ar_future = $request->input('ar_future');
                $discharges->added_by = auth('api')->user()->id;
                $user = User::where('id', auth('api')->user()->id)->first();
                if ($user->roles[0]->id == 3)
                    $discharges->status = 0;
                else
                    $discharges->status = 1;

                if (!$discharges->save()) {
                    $this->response = [
                        'status' => false,
                        'message' => 'خطأ',
                        'result' => 'خطأ في الإضافة'
                    ];
                    return response()->json($this->response);
                }

                $this->response = [
                    'status' => true,
                    'message' => 'تم بنجاح',
                    'result' => 'تمت الإضافة بنجاح'
                ];
                return response()->json($this->response);

            }

        


    }

}
