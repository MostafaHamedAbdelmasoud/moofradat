<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 9/24/2017
 * Time: 8:35 PM
 */ ?>
@extends('layouts.other')




@section('extraCss')
<style>
.snippet{
    padding:20px 0px;
}

.snippet ol {
    counter-reset: item;
    padding-left: 10px;
}
.snippet li {
    display: block;
    font-size:20px;
}
.snippet li:after {
    content: '\A';
    white-space: pre;
}
.snippet li:before {
    content: counters(item, ".") " ";
    counter-increment: item
}


</style>

@endsection

@section('content')


    <!-- contact section  -->
    <section class="contact">
        <div class="container">
            <div class="page-header">
                <h3 style="font-size:32px;">{{ $title }}</h3>
            </div>

            <p style="font-size:28px;color:red;">يرجى قراءة هذه الشروط بعناية فائقة قبل أن تبدأ باستخدام تطبيق مفردات، نحن نحتفظ بحق تعديل هذه الشروط وفقاً لتقديرنا الخاص دون إشعارك بذلك، وبمجرد استخدامك للتطبيق تكون قد قبلت بهذه الشروط ووافقت على الالتزام بها
            </p>
            <!--<p>-->
                 <div class="snippet">
                <?= html_entity_decode($terms->page_content) ?>
                     </div>
            <!--</p>-->
            
            
            <div class="snippet">
            
<!--            <ol>-->
                
<!--                <li>معلومات عنا -->
<!--                     <ol>-->
<!--                        <li>تطبيق مفردات هو تطبيق إلكتروني-->
<!--                         تعليمي لمفردات اللغة الإنجليزية يعمل على أنظمة Android و iOS، بطريقة سهلة ومبتكرة بحيث يسهل تعلم الكلمة وحفظها.</li> -->
<!--                    </ol>-->
<!--                </li>-->
                
<!--                  <li>-->
<!--                الوصول إلى التطبيق-->
                  
<!--                     <ol>-->
<!--                        <li>نحن نسعى دائماً لضمان إتاحة التطبيق بشكل عادي على مدار اليوم، لذا أنت توافق على أن تطبيق مفردات لن يكون ملتزماً إذا لم يكن التطبيق متاحاً لأي سبب في أي وقت أو لأي مدة.-->
                         
<!--                         </li>-->
                         
                         
<!--                          <li>-->
<!--أنت تتحمل مسؤولية الحصول على جميع الأجهزة الخاصة بالهاتف والحاسوب والبرمجيات والمعدات الأخرى اللازمة للوصول إلى واستخدام التطبيق وجميع النفقات المتعلقة بذلك.                          -->
<!--                         </li>-->
                         
<!--                    </ol>-->
<!--                </li>-->
                
                
                
<!--                  <li>-->
<!--               استخدام التطبيق-->
                  
<!--                     <ol>-->
<!--                        <li>-->
                            
                            
<!--باستكمالك عملية التسجيل في تطبيق مفردات فأنت تقر بأن لديك الأهلية القانونية الكاملة لإبرام العقود (بما في ذلك - على سبيل المثال: بلوغك السن القانوني اللازم لإبرام العقود). وتقر بأن المعلومات التي تقدّمها دقيقة وحديثة وستقوم بتحديثها في حال طرأ عليها أي تغيرات.                         -->
<!--                         </li>-->
                         
                         
<!--                         <li>-->
                             
<!--                             باستخدامك وتقديمك أي محتوى للتطبيق فإنك تمنحنا ترخيصاً غير حصري، ومجاني، ودائم، وقابل للتحويل، غير قابلا للنقض، وقابل للترخيص الفرعي من أجل استخدام المحتوى، وإعادة إنتاجه، وتعديله، وتحريره، وتكييفه، وترجمته، وتوزيعه، ونشره، ونسخه، وبثه وتوصيله بأي شكل من الأشكال.-->
                             
<!--                         </li>-->
                         
<!--                         <li>-->
                             
                             
<!--                             نحن لا نقدم أي ضمان بشأن دقة أي محتوى في التطبيق، ولا نقدم ضمان بأن ذلك المحتوى خالٍ من الأخطاء أو أنه موثوق أو بأن استخدامك للمحتوى لن ينتهك حقوق الغير.-->
                             
<!--                         </li>-->
                         
<!--                         <li>-->
                             
<!--                             نحن لا نقدم أي ضمان بأن الجوانب الوظيفية للتطبيق أو محتواه سيكون خالياً من الأخطاء، أو أن التطبيق أو محتوياته أو الخادم الذي يعمل على توفيره خالٍ من الفيروسات أو غيرها من المكونات الضارة.-->
                             
<!--                         </li>-->
                         
                         
<!--                         <li>-->
                             
<!--                             يحتفظ مفردات بالحق في إزالة أي محتوى من التطبيق يخالف هذه الشروط في أي وقت ولأي سبب من الأسباب. قد تكون تلك الإزالة فورية ودون سابق إنذار. وتقر بأن تطبيق مفردات ليس مسؤولاً تجاهك أو تجاه أي طرف ثالث مقابل أي إزالة من هذا القبيل.-->
                             
<!--                         </li>-->
                         
                         
                         
<!--                         <li>-->
                             
                             
<!--لا يجوز لك:-->

<!--                     <ol>-->
<!--                        <li>-->
                            
                            
<!--نشر أي مواد تحتوى على سب وقذف أو ألفاظ نابية أو مضايقة أو سوء معاملة، أو تنافي تعاليم الدين الإسلامي، أو تُخل بالآداب العامة.                        -->
<!--                         </li>-->
                         
                         
<!--                         <li>-->
                             
<!--نشر أي محتوى يتنافى مع تعاليم الدين الإسلامي، أو يُخل بالآداب العامة.                             -->
<!--                         </li>-->
                         
<!--                         <li>-->
                             
                             
<!--نشر أي محتوى يتسبب في إزعاج أو مضايقة الآخرين.                             -->
<!--                         </li>-->
                         
<!--                         <li>-->
                             
<!--نشر الرسائل أو المراسلات الإلكترونية غير المرغوب فيها أو ما شابه ذلك.                             -->
<!--                         </li>-->
                         
                         
<!--                         <li>-->
                             
<!--نشر أو إدخال أي مواد تحتوي على فيروسات أو أي برامج أخرى ضارة (Trojans، Worms، Logic Bombs، Time Bombs، Keystroke Loggers، Spyware، Adware) أو أية شفرات خبيثة أو ملفات أو برامج حاسوبية أخرى مصممة للإضرار بالتشغيل العادي للخدمة (أو أي جزء منها) أو التدخل فيه أو تحديده، أو لأي برمجيات أو أجهزة حاسوبية أخرى.                             -->
<!--                         </li>-->
                         
                         
<!--                    </ol>-->
                
                             
                             
                             
<!--                         </li>-->
                         
                         
                         
                         
<!--                    </ol>-->
<!--                </li>-->
                
                
                
                
               
                
                
                
                
                
                
                
                
                
                
                
                
                
                 
<!--                <li>-->
<!--            حقوق الملكية الفكرية-->

<!--                     <ol>-->
<!--                        <li>-->
                            
                            
<!--جميع الخدمات والمحتويات في هذا التطبيق وكافة حقوق التأليف والنشر والعلامات التجارية والأسماء التجارية والمظهر التجاري والتصاميم والشعارات والأيقونات، وغير ذلك من الملكيات الفكرية والمواد والحقوق المتعلقة بالتطبيق بما فيها الحقوق البرمجية وغيرها من الرموز التي يحتوي عليها بما في ذلك المحتوى والنصوص والصور والبرامج وملفات الصوت والفيديو والوثائق والأشكال (يُشار إليها مجتمعة بـ “الملكية الفكرية”) مملوكة لتطبيق مفردات و/أو مانحي التراخيص، وتُعد هذه هي المواد محمية بموجب قوانين المملكة العربية السعودية وحقوق التأليف والنشر الدولية والعلامات التجارية.-->


<!--</li>-->
                         
                         
<!--                         <li>-->
                             
<!--لا يجوز لك نشر أي من تلك المواد أو توزيعها أو إعادة ترخيصا أو ترجمتها أو إعادة إنتاجها بأي طريقة كانت بدون الحصول على موافقة كتابية مسبقة من تطبيق مفردات.                        -->
<!--                         </li>-->
                         
<!--                         <li>-->
                             
                             
<!--يجب عليك عدم استخدام أي جزء من المحتوي على التطبيق لأغراض تجارية دون الحصول على ترخيص منا للقيام بذلك أو المرخصين لدينا. إذا قمت بطباعة أو نسخ أو تنزيل أي جزء من التطبيق بما يخالف شروط الخدمة هذه، فسوف يتوقف حقك في استخدام التطبيق على الفور ويجب عليك إعادة أو إتلاف أي نسخ من المواد التي قمت بإجرائها.-->


<!--                         </li>-->
                         
<!--                         <li>-->
                             
<!--تطبيق مفردات وجميع العلامات التجارية وعلامات الخدمة والشعارات والأسماء التجارية وغيرها من العلامات التجارية ذات الصلة المرتبطة بالتطبيق هي علامات تجارية مملوكة من قبل تطبيق مفردات. ولا يجوز استخدام أي منها دون تفويض خطي مسبق من قبل أصحاب هذا التطبيق.                        -->
                        
<!--                         </li>-->
                         
                         
                         
                         
<!--                    </ol>-->
<!--                </li>-->
                
                
                
                
                
                
                 
<!--                <li>-->
<!--            إخلاء المسئولية-->

<!--                     <ol>-->
<!--                        <li>-->
                            
                            
<!--يتم توفير التطبيق وجميع المعلومات والمحتويات والخدمات وغيرها من البنود المتاحة لك من خلال وبواسطة التطبيق (مجتمعة، "محتويات التطبيق") على أساس "كما هو متاح" أو "كما هو متوفر"، دون أي إقرارات أو ضمانات من أي نوع.-->



<!--</li>-->
                         
                         
<!--                         <li>-->
                             
<!--نحن نسعى إلى بذل أفضل قدراتنا للتأكد من اتاحة التطبيق للاستخدام بشكل عادي، ولكن لا نتحمل المسئولية عن أي انقطاع محتمل للخدمة بسبب -على سبيل المثال لا الحصر- أعمال الصيانة أو المشكلات الفنية أو غيرها من الأسباب المماثلة.-->

<!--                         </li>-->
                         
<!--                         <li>-->
                             
                             
<!--نحن نسعى لضمان صحة وتحديث المحتوى، إلا أننا لا نقدم أي شرط أو ضمان أو إقرار أو تعهد صريح أو ضمني من حيث دقة هذا المحتوى أو موثوقيته. ويجوز لنا إجراء تعديلات على المحتوى في أي وقت دون إشعار، ولا نقدم أي التزام بتحديث مثل هذا المحتوى.-->


<!--                         </li>-->
                         
<!--                         <li>-->
                             
<!--قد نعرض على التطبيق أسماء أو علامات أو إعلانات أو خدمات لأطراف ثالثة أو نصوص منبثقة أو روابط خارجية. إذا قررت الارتباط بأي من مواقع الجهات الخارجية، فإنك تقوم بذلك بالكامل على مسؤوليتك الخاصة.                        -->
                         
<!--                         </li>-->
                         
<!--                         <li>-->
                             
<!--                             نحن لا نضمن بأن التطبيق أو الخادم الخاص به سيكون خالياً من الأخطاء دون انقطاع، أو خالياً من الوصول غير المصرح به، أو أن أي بريد إلكتروني يتم إرساله من التطبيق خالياً من الفيروسات أو المكونات الضارة الأخرى أو أن التطبيق سيُلبي متطلباتك.-->
<!--                         </li>-->
                         
<!--                         <li>-->
                             
<!--                             نحن لا نتحمل أية مسؤولية عن أي استخدام لأي محتوى تم وضعه أو تخزينه أو رفعه من قبل أي طرف ثالث. -->
                             
<!--                         </li>-->
                         
<!--                         <li>-->
                             
<!--نحن لا نتحمل أي مسؤولية عن أي روابط لأي مواقع خارجية يُمكن الوصول إليها من خلال التطبيق أو عن أي تعليمات مقدمة فيها أو محتوى لمثل هذه المواقع.-->

<!--                         </li>-->
                         
<!--                          <li>-->
                             
<!--نحن لا نتحمل أي مسؤولية بأي حال من الأحوال عن الأضرار المباشرة أو غير المباشرة أو العرضية أو الخاصة أو العقابية أو التبعية، والتي تنتج من استخدامك أو إساءة استخدامك للتطبيق.-->

<!--                         </li>-->
                         
                         
<!--                          <li>-->
                             
<!--تُشكل إخلاء المسؤولية هذه جزءاً أساسياً من شروط الخدمة هذه.-->

<!--                         </li>-->
                         
                         
<!--                    </ol>-->
<!--                </li>-->
                
                
                
                
                 
<!--                <li>-->
<!--           الاتصالات الإلكترونية-->

<!--                     <ol>-->
<!--                        <li>-->
                            
                            
<!--من خلال توفير عنوان بريدك الإلكتروني في تطبيق مفردات، فأنت توافق علي تلقي رسائل البريد الالكتروني الترويجية منا. لإلغاء الاشتراك في اتصالات البريد الإلكتروني هذه، يمكنك النقر على رابط "إلغاء الاشتراك" الموجود أسفل رسائل البريد الإلكتروني الخاصة بنا.-->


<!--</li>-->
                         
                        
                         
<!--                    </ol>-->
<!--                </li>-->
                
                
                
                   
<!--                <li>-->
<!--           الروابط لمواقع الأطراف الثالثة-->

<!--                     <ol>-->
<!--                        <li>-->
                            
                            
<!--قد يحتوي التطبيق على روابط لمواقع أخرى، بما في ذلك المواقع الاجتماعية. وحيث أن هذه المواقع لا تخضع لرقابتنا، لذا لا نتحمل أي مسئولية عن نوعية أو محتوى أو طبيعة أو دقة أي موقع أو رابط آخر يمكن الوصول إليه من خلال أي رابط على تطبيق مفردات أو المواقع المرتبطة به سواء بطريقة مباشرة أو غير مباشرة. يرجى التوجه لمسؤول المواقع الخارجية مباشرة عند حدوث أي مشكلة بشأن الرابط.-->

<!--</li>-->


<!--  <li>-->
                            
                            
<!--أنت توافق على أن تطبيق مفردات لن يكون طرفاً في أي معاملة أو عقد يمكنك الدخول فيه مع أي طرف ثالث. ولن يتحمل أي مسؤولية تجاهك عن أي خسارة أو ضرر قد تتعرض لها باستخدام تلك المواقع والخدمات الخاصة بأي طرف ثالث. -->

<!--</li>-->

                        
                         
<!--                    </ol>-->
<!--                </li>-->
                
                
                  
                   
<!--                <li>-->
<!--           التعويض-->
           
<!--                     <ol>-->
<!--                        <li>-->
                            
                            
<!--لا يتحمل تطبيق مفردات والتابعين له والوكلاء المرخصين أو الجهات المرخصة له أي تعويضات أو دفع تكاليف أو رسوم أو أتعاب تنشأ عن استخدامك للتطبيق أو المحتوى.-->

<!--</li>-->

                        
                         
<!--                    </ol>-->
<!--                </li>-->
                
                
<!--                 <li>-->
<!--           التعديلات-->
           
<!--                     <ol>-->
<!--                        <li>-->
                            
                            
<!--يجوز لنا - وفقاً لتقديرنا الخاص- تغيير أو تعديل أي جزء من هذه الشروط في أي وقت حسبما نراه مناسباً ويعتبر أي تعديل على هذه الشروط ساري المفعول فور نشره على التطبيق. وعند استخدامك للتطبيق بعد إجراء تلك التغييرات يكون بمثابة الموافقة على الالتزام بالشروط المعدلة. لذا نرجو منك مراجعة وقراءة هذه الشروط بانتظام للتأكد من الشروط السائدة عند استخدام التطبيق.-->
<!--</li>-->

                        
                         
<!--                    </ol>-->
<!--                </li>-->
                
                
<!--                 <li>-->
<!--           الإنهاء-->
           
<!--                     <ol>-->
<!--                        <li>-->
                            
                            
<!--يحق لنا وفقاً لتقديرنا الخاص في إنهاء أو تقييد أو إيقاف أي مستخدم من الوصول إلى أو استخدام التطبيق بدون إشعار مسبق لأي سبب قد نعتبره غير قانوني أو ضار بالآخرين. وبالمثل، يمكنك التوقف عن استخدام الخدمات في أي وقت وبدون إشعار لنا.-->

<!--</li>-->

                        
                         
<!--                    </ol>-->
<!--                </li>-->
                
                
                
<!--                 <li>-->
<!--           القوانين والاختصاص القضائي-->
           
<!--                     <ol>-->
<!--                        <li>-->
                            
                            
<!--تخضع شروط الخدمة هذه وتفسر وفقاً لقوانين المملكة العربية السعودية، وتخضع كافة النزاعات الناشئة عنها إلى سلطة الاختصاص الحصري للمحاكم السعودية.-->

<!--</li>-->

                        
                         
<!--                    </ol>-->
<!--                </li>-->
                
                
                
                  
<!--                 <li>-->
<!--الاتصال بنا           -->
<!--                     <ol>-->
<!--                        <li>-->
                            
                            
<!--إذا كانت لديك أية أسئلة أو استفسارات حول هذه الشروط، يرجى الاتصال بنا على البريد الإلكتروني ........................... أو هاتف رقم ................................-->

<!--</li>-->

                        
                         
<!--                    </ol>-->
<!--                </li>-->
                
                
                
                
                
               
<!--            </ol>-->
            
<!--                <div style="text-align:center;padding-top:20px;">-->
<!--                <h4>جميع الحقوق محفوظة © مفردات 2020</h4>-->
<!--                <h4>تاريخ السريان: مارس 2020-->
<!--                </h4>-->
<!--                </div>-->
            </div>
            
        </div>
    </section>



@endsection