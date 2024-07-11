<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            margin: 0 10px;
            padding: 0 10px;
            font-family:Arial, Helvetica, sans-serif;
            /*line-height: 20px;*/
            font-size: 14px;
            line-height:20px;
            border: groove 3px gray;

        }
        .zew{
            font-size: 16px;
            font-weight: bold;
        }
        .zew2
        {
            text-decoration: underline;
            font-weight: bold;
        }
        .imageHandle{
            width: 140px !important;
            height: 110px !important;
        }
    </style>
</head>
<body dir="rtl">
<section>


<section style="display: flex; justify-content:  space-between">

   <div style="text-align: center">
       <h2 >طلب حجز موعد لإتمام مراسم طقس صلاة  (code:{{$appointment->number}})</h2>
       <h2 >الأكليل بكنيسة الملاك ميخائيل بشيراتون</h2>
   </div>
   <div>
        <img src="https://i.imgur.com/dHAcQey.jpeg" alt="" class="imageHandle" >
   </div>
</section>
    <span class="zew"><br>بناء على طلب كلاً من :		</span>
    <span class="zew"><br>السيد/ 	{{$appointment->man_name}} [رقم قومى{{$appointment->man_id}} , Tel :{{$appointment->man_phone}} ]</span>
    <span class="zew"><br>والأنسة/ 	{{$appointment->women_name}} [رقم قومى{{$appointment->women_id}} , Tel :{{$appointment->women_phone}} ]</span>
    <span class="zew"><br>ومحلهما المختار :	  {!!$appointment->address!!}</span>
    <span class="zew"><br>تم حجز موعد يوم	{{$appointment->getFormatedDate()}} 	بدءاً من : {{$appointment->getFormatedTime()}}  ولمدة {{$appointment->the_numbers_of_hours}} ساعة</span>
    <span style="font-weight: bold" ><br> وذلك لإتمام مراسم طقس صلاة أكليل طبقا لتصريح الزواج رقم .............. الصادر بتاريخ ..................</span>
    <br ><span style="text-decoration:underline;font-weight: bold">ويقر الحاجز بالإتزام بالشروط والتعهدات العامة التالية بدقة :-</span>
    <br>1- بالنسبة للأكاليل:يلغى الحجز تلقائيا مالم يتم إحضار تصريح الزواج الصادر من الكاتدرائية المرقسية بالقاهرة <span style="text-decoration:underline ;font-size: 20px;color:red"> قبل  {{$appointment->getpreviuos()}}</span>.
    <br>"2- الإلتزام بالحضور فى بداية الموعد المحجوز وذلك حرصا على اداء الصلوات الطقسية بدون استعجال وبما يليق بكرامة اتمام السر المقدس
    <br>وفى حالة التأخير اكثر من نصف ساعة يؤجل الحجز لأخر موعد متاح <span class="zew2">مع سداد رسوم حجز ساعة + فيديو إضافيين."</span>
    <br>3- الإلتزام التام بموعد الأنصراف دون تجاوز الوقت المحجوز حتى لا يؤثر على مواعيد الصلوات التالية (لا يسمح بأكثر من 5 دقائق تأخير) .
    <br>4- عدم إستخدام الأعيرة النارية أو الصوتية أو الألعاب النارية ايا كان نوعها (حتى لو كانت مرخصة قانونيا) بمنطقة الكنيسة على الأطلاق .
    <br>5- عدم استخدام مصورين فيديو سوى المعينين من قبل الكنيسة حيث انهم قائمون بعمل كل التوصيلات وتقينات الفيديو الموجودة بالكنيسة
    <br>رد التأمين المدفوع ضمن بيان الحجز :-
    <br> +) يتم رد قيمة التأمين مقابل الألتزام بكل الشروط والتعهدات العامة سالفة الذكر وكذلك الشروط الموضحة ببيان الحجز.
    <br> +) يسترد مبلغ التأمين (لأحد العروسين او الأباء او الشخص الذى قام بالحاجز) بعد 15 يوم وخلال 90 يوم من تاريخ الأكليل/الخطوبة .
    <br> +) يرد التأمين عن طريق مكتب الحسابات بالكنيسة ( ت 111111 ) خلال مواعيد العمل (من 10 ص الى 2 ظهراً عدا ايام الجمع والأحاد)
    <br>+) <span class="zew2">يراعى تقديم اصل الأيصال (وإلا يخصم 500جم مع عمل اقرار شخصى)</span> عند طلب استرداد التأمين واستلام فلاشة الفيديو (ان كانت مطلوبة)
    <br>+) يتم إستخدام قيمة التأمين فى حال عدم إسترداده  فى الخدمات  التى تقدمها الكنيسة  للفقراء والمحتاجين والرعاية الإجتماعية.

    <br>تعديل او تأجيل موعد الحجز :-
    <br>+) يجوز خلال إسبوعين من تاريخ هذا الحجز  أن يتم تعديل موعد الحجز مرة واحدة فقط دون تكاليف اضافية .
    <br>+) كذلك يقبل فى حالة الظروف الطارئة (طبقاً لشهادة وفاه اقارب حتى الدرجة الثانية) أن يتم تعديل الموعد المحجوز دون تكاليف اضافية.
    <br>+) فى حالة تكرار تعديل الموعد المحجوز  (لأي سبب) <span class="zew2">يتم تطبيق كل مرة رسم تعديل مبلغ 500 جنيها ( خمسمائة جنيها)</span>  .
    <br>+) تطبق رسوم اضافية  50%  من قيمة حجز الكنيسة اذا تم طلب التعديل بعد <span style="text-decoration:underline ;font-size: 20px;color:red">   {{$appointment->getNextMonth()}}</span>  ولأي سبب من الأسباب.

    <br><span class="zew">فى حالة الغاء موعد الحجز</span> :-
    <br>+) يتم رد كامل المبلغ المدفوع فى حالة الألغاء للظروف الطارئة (طبقاً لشهادة وفاه اقارب حتى الدرجة الثانية ).
    <br>+)  يتم رد المبلغ المدفوع مخصوماً منة مبلغ 500 جم فقط (مصاريف أدارية) فى حالة الغاء الحجز خلال اسبوعين من تاريخة.
    <br>+) تطبق نسب الغرامات التالية على قيمة "حجز الكنيسة" (توجة لأخوة الرب) فى حالة الألغاء قبيل الموعد المحجوز كالأتى:
    <br>+) يخصم نسبة  100%  من قيمة حجز الكنيسة اذا تم طلب الألغاء <span style="text-decoration:underline ;font-size: 20px;color:red"> قبل  {{$appointment->getNextMonth()}}</span>
    <br>+) يخصم نسبة 75%  من قيمة حجز الكنيسة اذا تم طلب الألغاء <span style="text-decoration:underline ;font-size: 20px;color:red"> قبل  {{$appointment->getNextTowMonth()}}</span>
    <br>ملاحظات وخدمات اخرى تقدمها الكنيسة :-		</br>
    <br><span style="text-decoration: underline;font-weight: bold">+) توفر الكنيسة خدمات أضافية إختيارية مثل : بث مباشر بالإنترنت/ تصوير فوتوغرافى/.</span>
    <br>+) يراعى تأكيد كافة الخدمات الأضافية المطلوبة <span style="text-decoration:underline ;font-size: 20px;color:red"> قبل  {{$appointment->getNextMonth()}}</span>  (والا تطبق 50% زيادة على قيمة الخدمة الأضافية المطلوبة)
    <br>+) يسرى الحجز بعد ختم هذا الطلب والمسجل علية كود الحجز وبعد دفع المبالغ الموضحة ببيان الحجز
    <br>+) يحق للكنيسة عمل أى صيانة أو ترميمات ضرورية وفى أي وقت بما لا يتعارض مع صلاة الإكليل .
    <br>هذا ويسعدنا الرد على استفساراتكم (موبايل/واتسأب 01205880818)  او اثناء مواعيد المكتب (10ص ّ 2م يومياً)+(7م ~ 9م عدا الاثنين)

    <div style="display: flex; justify-content: space-between">
        <div>
            <br>أقرار  وتعهد بالألتزام بشروط الحجز
            <br>اقر انا  :
            <br>رقم قومى :
            <br>بأننى اطلعت على الشروط أعلاه واتعهد بالإلتزام بها.
        </div>
       <div>
           <br>التوقيع
           <br >التاريخ :
           <br>تليفون :
       </div>
        <div>

        </div>
    </div>
</section>

</body>
</html>





