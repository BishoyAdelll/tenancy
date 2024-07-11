<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Invoice {{$record->id}}</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }
        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: sans-serif;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }


        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }
        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .InvoiceMargin
        {
            margin-top: 400px ;
        }

        .text-start {
            text-align: left;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-blue {
            background-color: #414ab1;
            color: #fff !important;
        }.bg-red {
            background-color: #e30e3f;
            color: #fff !important;
        }
         .imageHandle{
             width: 140px !important;
             height: 110px !important;
         }
    </style>
</head>
<body>

    <table class="order-details">
        <thead>

            <tr>

                <th width="50%" colspan="2" >
                    <div>
                        <img src="https://i.imgur.com/dHAcQey.jpeg" alt="" class="imageHandle" >
                    </div>
{{--                    <h2 >welcome to  {{(__('filament.church'))}}</h2>--}}
                </th>
                <th width="50%" colspan="2" class="text-end company-data">
                    <span>Invoice Id: {{$record->id}}</span> <br>

                    <span>Date & Time: {{$record->created_at}}</span> <br>

                    <span>Zip code :  </span> <br>
{{--                    @dd($record->hall->name)--}}
                    <span>Address: {{$hall->address}} </span> <br>


                    <a href="{{$hall->location}}" type="button">Location </a><br>

                </th>
            </tr>
            <tr class="bg-blue">
                <th width="50%" colspan="2">Customer Details</th>
                <th width="50%" colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Order Id:</td>
                <td>{{$record->number}}</td>

                <td>Man Name:</td>
                <td>{{$record->man_name}}</td>
            </tr>
            <tr>

                <td>Address:</td>
                <td>{{$hall->address}}</td>

                <td>Women Name:</td>
                <td>{{$record->women_name}}</td>

            </tr>
            <tr>
                <td>Ordered Date:</td>
                <td>{{$record->created_at}}</td>

                <td>Man Phone:</td>
                <td>{{$record->man_phone}}</td>
            </tr>
            <tr>
                <td>Payment Mode:</td>
                <td>{{$record->Payment}}</td>
                <td>Women Phone.:</td>
                <td>{{$record->women_phone}}</td>

            </tr>
            <tr>
                <td>Order Status:</td>
                <td>{{$record->status}}</td>
                <td>Email:</td>
                <td>{{$record->email}}</td>

            </tr>

            <tr class="bg-blue">
                <th  class="total-heading" style="text-align:center"> Addition Place </th>
                <th colspan="2" >Start Time</th>
                <th  >End  Time  </th>
            </tr>
            <tr>

                <td  style="text-align: center"> <span class="font2"><h3>{{$hall->name}}</h3></span> </td>
                <td  colspan="2" style="text-align: center"> <span class="font2"><h3>{{\Carbon\Carbon::parse($record->start_time)->format('Y-m-d l h:i A')}}</h3></span> </td>
                <td  style="text-align: center" ><h3>{{\Carbon\Carbon::parse($record->end_time)->format('Y-m-d l h:i A')}}</h3> </td>
            </tr>



        </tbody>
    </table>





    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                    Order Items
                </th>
            </tr>

        </thead>

        <tbody>

{{--        {{$record->test()}}--}}{{----}}
        <tr class="bg-blue">
            <th colspan="2" class="total-heading" style="text-align:center">Add on Name </th>
            <th colspan="1" >Addition Description</th>
            <th colspan="1" >quantity </th>
            <th colspan="1" >price </th>
            <th colspan="1" >Price * Quantity </th>
        </tr>


        @if ($tests != null)
        @foreach ($tests as $product)
        <tr>

            <td colspan="2" >{{$product->addition->name}}</td>
            <td colspan="1" style="text-align: center"> <span class="font2">{{$product->addition->description}}</span> </td>

            <td colspan="1" >{{$product->quantity}} </td>
            <td colspan="1" >{{$product->price}} EG</td>
            <td colspan="1" >{{$product->total_addtions }} EG</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="6" style="text-align: center"> <span class="font2">Not Found Addtion</span> </td>
        </tr>
        @endif


            <tr>
                <td colspan="2" class="total-heading">Booking amount</td>

                <td colspan="1"  style="text-align:center">{{$hall->name}} </td>
                <td colspan="1"  >{{$record->the_numbers_of_hours}} Hour</td>
                <td colspan="1"  >{{$record->hall_price}} EG</td>
                <td colspan="3"  >{{$record->total_price}} EG</td>

            </tr>
            <tr>
                <td colspan="5" class="total-heading">Photography Services</td>

                <td colspan="3"  >{{$record->photography}} EG</td>
            </tr>
            <tr>
                <td colspan="5" class="total-heading">deposit</td>

                <td colspan="3"  >{{$record->paid}} EG</td>
            </tr>

            <tr class="bg-blue">
                <th colspan="3" class="total-heading" style="text-align:center">Total invoice </th>
                <th colspan="1" >tax</th>
                <th colspan="1" >discount </th>
                <th colspan="1" >Total invoice </th>
            </tr>
            <tr>
                <td colspan="3" class="total-heading">Total Amount - <small>Inc. all vat/tax</small> :</td>
                <td colspan="1" >{{$record->tax}} <span style="float: right">TAX</span></td>
                <td colspan="1" >{{$record->discount}} <span style="float: right">%</span></td>
                <td colspan="1" >{{$record->grand_total}} <span style="float: right">EG</span></td>
            </tr>
            <tr>
                <td colspan="5" class="total-heading">insurance</td>

                <td colspan="3"  style="color:red">{{$record->insurance}} EG</td>
            </tr>
            @if($record->hall_rival != 0  && $record->status == \App\Enums\Status::Cancelled->value )
                <tr class="bg-blue">
                    <th colspan="5" class="total-heading" style="text-align:center">Total Fines </th>

                    <th colspan="1" >Total Fines </th>
                </tr>
                <tr>
                    <td colspan="5" class="total-heading"> <small>Appointment cancellation fines</small> :</td>

                    <td colspan="1" >{{$record->hall_rival}} <span style="float: right">EG</span></td>
                </tr>
                <tr>
                    <td colspan="5" class="total-heading"><small> Amount due</small> :</td>

                    <td colspan="1" >{{$record->residual}} <span style="float: right">EG</span></td>
                </tr>

            @endif





        </tbody>
    </table>
    <br>
    <p class="text-center">
        Thank you for booking on {{(__('filament.church'))}}
    </p>

    @if($record->is_edited == 1 || count($record->dates) >= 2 )
        <h4 class="bg-red text-center  InvoiceMargin" >This date has been previously modified </h4>

        <table >

            <tr class="bg-red">
                <th  class="total-heading" style="text-align:center"> dates</th>
                <th  colspan="2" style="text-align:center"> Appointment date </th>
                <th  >start Time </th>
            </tr>
            @if($record->dates > 1)
                @foreach($record->dates as $date)
                    <tr>

                        <td  style="text-align: center"> <span class="font2"><h3>Edited dates </h3></span> </td>
                        <td  colspan="2" style="text-align: center"> <span class="font2"><h3>{{\Carbon\Carbon::parse($date)->format('F d Y')}}</h3></span> </td>
                        <td  style="text-align: center" ><h3>{{\Carbon\Carbon::parse($date)->format('h:i A')}}</h3> </td>

                    </tr>

                @endforeach
            @endif
        </table>
    @endif
{{--<button onclick="window.print()">print This  page </button>--}}



</body>
</html>
