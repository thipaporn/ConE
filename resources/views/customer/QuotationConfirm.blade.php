@extends('header-footer')

@section('header')
<!-- csrf-token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

	<section class="bg-title-page p-t-50 p-b-40 flex-col-c-m" style="background-image: url(images/product.jpg);">
		<h2 class="l-text0 t-center" style="color:#3d3d3d;padding:30px;padding-left:100px;padding-right:100px;background-color: #cccccc;opacity: 0.85;">
			รายการคำสั่งซื้อ
		</h2>
	</section>
	<br>
	<div>	
	
    <div class="wrap_menu">
	    <nav class="menu">
			<ul class="main_menu">
                <li>
					<form action="customer" method="get">
						<div class="w-size2 p-t-20">
							<input type="hidden" name="กำลังขอ" class="form-control">
							<span class="header-icons-noti2 m-t-30 m-r-25">{{$count1}}</span>
							@if(isset($_GET['กำลังขอ']))
							<button class="manu-noti flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">	
								กำลังขอ
							</button>
							@elseif(isset($_GET['รอยืนยัน']) || isset($_GET['ต่อรองราคา']) || isset($_GET['รอชำระเงิน']))
							<button class="flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">	
								กำลังขอ
							</button>
							@else
							<button class="manu-noti flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">	
								กำลังขอ
							</button>
							@endif
						</div>
					</form>
                </li>

                <li>
					<form action="customer" method="get">
						<div class="w-size2 p-t-20">
							<input type="hidden" name="รอยืนยัน" class="form-control">
							<span class="header-icons-noti2 m-t-30 m-r-25">{{$count2}}</span>
							@if(isset($_GET['รอยืนยัน']))
							<button class="manu-noti flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">	
								รอยืนยัน
							</button>
							@else
							<button class="flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">	
								รอยืนยัน
							</button>
							@endif
						</div>
					</form>
                </li>

                <li>
					<form action="customer" method="get">
						<div class="w-size2 p-t-20">
							<input type="hidden" name="ต่อรองราคา" class="form-control">
							<span class="header-icons-noti2 m-t-30 m-r-25">{{$count3}}</span>
							@if(isset($_GET['ต่อรองราคา']))
							<button class="manu-noti flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">	
								ต่อรองราคา
							</button>
							@else
							<button class="flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">	
								ต่อรองราคา
							</button>
							@endif
						</div>
					</form>
                </li>

                <li>
					<form action="customer" method="get">
						<div class="w-size2 p-t-20">
							<input type="hidden" name="รอชำระเงิน" class="form-control">
							<span class="header-icons-noti2 m-t-30 m-r-25">{{$count}}</span>
							@if(isset($_GET['รอชำระเงิน']))
							<button class="manu-noti flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">	
								รอชำระเงิน
							</button>
							@else
							<button class="flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">	
								รอชำระเงิน
							</button>
							@endif
						</div>
					</form>
                </li>
            </ul>			
        </nav>
		
	</div>
	<div class="card sticky t-center">
		ยอดสะสม : {{$sum}} บาท
		<br>
		<p>{{$sum}} / 500,000</p>
		<div class="progress t-center">
			<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent; ?>%;background-color:#fcc404;color:black;"></div>
			
		</div>
		@if($percent == 100)
			<p style="color:green;">ยินดีด้วย !! &nbsp;คุณมีสิทธิ์ได้รับทอง <i class="fa fa-gift"></i></p> 		
		@endif
	</div>
	<!---------------------------status------------------------------------------------->
	@if (isset($_GET['กำลังขอ']))
	<h4 class="l-text10 t-left">
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รายการขอใบเสนอราคาทั้งหมด &nbsp;&nbsp;{{$count1}}&nbsp;&nbsp;รายการ<br><br>
	</h4>	
	<div class="container">

		@if($count1 > 0)
			@foreach($orders as $index => $order)
				@if($order[0]->oStatus == 'อยู่ในระหว่างการขอใบเสนอราคา')
				<div class="card col-md-12 ">
					<div class="row">
						<div class="contentCard contentCardOrder col-md-3">
							<p class="head-cart">ออเดอร์เลขที่ : {{$order[0]->oID}}</p>
							<p><i class="fa fa-user"></i> &nbsp;&nbsp;:&nbsp; {{$order[0]->oShipName}}</p>
							<p><i class="fa fa-calendar"></i></i> &nbsp;:&nbsp; {{$order[0]->oDate}}</p><br>
						</div>
						<div class="contentCard col-md-6">
							<p class="head-cart">รายการสินค้า</p>
							<ol>
							@foreach($order as $product)
								@foreach($products as $pro)
									@if($product->pID == $pro->pID)
										<li> {{$pro->tName}} ({{$pro->pBrand}}) {{$pro->pSize}} {{$pro->pThick}} &nbsp;&nbsp; (จำนวน : {{$product->dQuantity}} {{$pro->pUnit}}) </li>
									@endif
								@endforeach
							@endforeach
							</ol>
						</div>

						<div class="contentCard contentCardStatus col-md-3 center">
							<p class="head-card">{{$order[0]->oStatus}}</p>
						</div>
					</div>
				</div>
				@endif
			@endforeach
		@else
			<br>
			<h4 style="color: #BEBEBE;" align="center">ยังไม่มีรายการ</h4>
			<br>
		@endif
		</div>

	<!---------------------------status------------------------------------------------->
	@elseif (isset($_GET['รอยืนยัน']))
		<h4 class="l-text10 t-left">
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รายการรอยืนยันใบเสนอราคาทั้งหมด &nbsp;&nbsp;{{$count2}}&nbsp;&nbsp;รายการ<br><br>
		</h4>
		<div class="container">

		@if($count2 > 0)
			@foreach($orders as $index => $order)
				@if($order[0]->oStatus == 'รอยืนยันใบเสนอราคา')
				<div class="card col-md-12">
					
					<div class="row">
						<div class="contentCard contentCardOrder col-md-3">
							<p class="head-card">ออเดอร์เลขที่ : {{$order[0]->oID}}</p><p><i class="fa fa-user"></i> &nbsp;&nbsp;:&nbsp; {{$order[0]->oShipName}}</p>
							<p><i class="fa fa-calendar"></i></i> &nbsp;:&nbsp; {{$order[0]->oDate}}</p>
							<p style="color:red;"><i class="fa fa-hourglass-half" ></i></i> &nbsp;:&nbsp; {{$order[0]->oExp}} &nbsp;
							<?php
								$ts1 = strtotime($order[0]->oExp);
								$ts2 = strtotime(date("Y-m-d"));
								$diff = ($ts1 - $ts2)/3600/24;
								echo "( เหลือ : $diff วัน )"
							?></p><br>
							<input id="oID{{$index}}" type="hidden" value="{{$order[0]->oID}}">
							<a id="oID{{$index}}" class="pdf btn btn-warning" style="margin-top:8px; cursor:pointer;">ดูใบเสนอราคา</a></p>
						</div>
						<div class="contentCard col-md-6">
							<p class="head-card">รายการสินค้า</p>
							<ol>
							@foreach($order as $product)
								@foreach($products as $pro)
									@if($product->pID == $pro->pID)
										<li> {{$pro->tName}} ({{$pro->pBrand}}) {{$pro->pSize}} {{$pro->pThick}} &nbsp;&nbsp; (จำนวน : {{$product->dQuantity}} {{$pro->pUnit}}) </li>
									@endif
								@endforeach
							@endforeach
							</ol>
							<p align=right style="padding-right: 30px;">
								
								<input id="cancel{{$index}}" type="hidden" value="{{$order[0]->oID}}">
								<a id="cancel{{$index}}" href="#" class="cancel btn btn-outline-danger" style="margin-left: 12px; margin-top:8px;" >ปฏิเสธ</a>
								
								<input id="bargain{{$index}}" type="hidden" value="{{$order[0]->oID}}">
								<a id="bargain{{$index}}" href="#" class="bargain btn btn-outline-primary" style="margin-left: 12px; margin-top:8px;" >ต่อรองราคา</a>					
								
								
								<input id="confirm{{$index}}" type="hidden" value="{{$order[0]->oID}}">
								<a id="confirm{{$index}}" class="confirm btn btn-success" style=" margin-left: 12px; margin-top:8px; cursor:pointer; color:white" >ยืนยันใบเสนอราคา</a>
							</p>
						</div>
						
						<div class="contentCardStatus contentCard center col-md-3">

							<p class="head-card" align=center>{{$order[0]->oStatus}}<br>
							</p>

						</div>
						
						<br>
					</div>
				</div>
				@endif
				@if($order[0]->oStatus == 'รอยืนยันการต่อรองราคา')
				<div class="card col-md-12">
					<div class="row">
						<div class="contentCard contentCardOrder col-md-3">
							<p class="head-card">ออเดอร์เลขที่ : {{$order[0]->oID}}</p>
							<p><i class="fa fa-user"></i> &nbsp;&nbsp;:&nbsp; {{$order[0]->oShipName}}</p>
							<p><i class="fa fa-calendar"></i></i> &nbsp;:&nbsp; {{$order[0]->oDate}}</p>
							<p style="color:red;"><i class="fa fa-hourglass-half" ></i></i> &nbsp;:&nbsp; {{$order[0]->oExp}} &nbsp;
							<?php
								$ts1 = strtotime($order[0]->oExp);
								$ts2 = strtotime(date("Y-m-d"));
								$diff = ($ts1 - $ts2)/3600/24;
								echo "( เหลือ : $diff วัน )"
							?></p><br>
							<input id="oID{{$index}}" type="hidden" value="{{$order[0]->oID}}">
							<a id="oID{{$index}}" class="pdf btn btn-warning" style="margin-top:8px; cursor:pointer;">ดูใบเสนอราคา</a></p>
						</div>
						<div class="contentCard col-md-6">
							<p class="head-card">รายการสินค้า</p>
							<ol>
							@foreach($order as $product)
								@foreach($products as $pro)
									@if($product->pID == $pro->pID)
										<li> {{$pro->tName}} ({{$pro->pBrand}}) {{$pro->pSize}} {{$pro->pThick}} &nbsp;&nbsp; (จำนวน : {{$product->dQuantity}} {{$pro->pUnit}}) </li>
									@endif
								@endforeach
							@endforeach
							</ol>
							<p align=right style="padding-right: 30px;">
								
								<input id="cancel{{$index}}" type="hidden" value="{{$order[0]->oID}}">
								<a id="cancel{{$index}}" href="#" class="cancel btn btn-outline-danger" style="margin-left: 12px; margin-top:8px;" >ปฏิเสธ</a>				
								
								
								<input id="confirmOrder{{$index}}" type="hidden" value="{{$order[0]->oID}}">
								<a id="confirmOrder{{$index}}" class="confirmOrder btn btn-success" style=" margin-left: 12px; margin-top:8px; cursor:pointer; color:white" >ยืนยันใบเสนอราคา</a>
							</p>
						</div>
						<div class="contentCard contentCardStatus col-md-3 center">
							<p class="head-card">{{$order[0]->oStatus}}</p>							
						
						</div>
						<br>
					</div>
				</div>
				@endif
			@endforeach
		@else
			<br>
			<h4 style="color: #BEBEBE;" align="center">ยังไม่มีรายการ</h4>
			<br>
		@endif
		</div>

	<!---------------------------status------------------------------------------------->
	@elseif (isset($_GET['ต่อรองราคา']))
		<h4 class="l-text10 t-left">
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รายการต่อรองราคาทั้งหมด &nbsp;&nbsp;{{$count3}}&nbsp;&nbsp;รายการ<br><br>
		</h4>
		<div class="container">
		
		@if($count3 > 0)
			@foreach($orders as $index => $order)
				@if($order[0]->oStatus == 'อยู่ในระหว่างการต่อรองราคา')
				
				<div class="card col-md-12">
					<div class="row">
						<div class="contentCard contentCardOrder col-md-3">
							<p class="head-card">ออเดอร์เลขที่ : {{$order[0]->oID}}</p>
							<p><i class="fa fa-user"></i> &nbsp;&nbsp;:&nbsp; {{$order[0]->oShipName}}</p>
							<p><i class="fa fa-calendar"></i></i> &nbsp;:&nbsp; {{$order[0]->oDate}}</p>
							<p style="color:red;"><i class="fa fa-hourglass-half" ></i></i> &nbsp;:&nbsp; {{$order[0]->oExp}} &nbsp;
							<?php
								$ts1 = strtotime($order[0]->oExp);
								$ts2 = strtotime(date("Y-m-d"));
								$diff = ($ts1 - $ts2)/3600/24;
								echo "( เหลือ : $diff วัน )"
							?></p><br>
							<input id="oID{{$index}}" type="hidden" value="{{$order[0]->oID}}">
							<a id="oID{{$index}}" class="pdf btn btn-warning" style="margin-top:8px; cursor:pointer;">ดูใบเสนอราคา</a></p>
						</div>
						<div class="contentCard col-md-6">
							<p class="head-card">รายการสินค้า</p>
							<ol>
							@foreach($order as $product)
								@foreach($products as $pro)
									@if($product->pID == $pro->pID)
										<li> {{$pro->tName}} ({{$pro->pBrand}}) {{$pro->pSize}} {{$pro->pThick}} &nbsp;&nbsp; (จำนวน : {{$product->dQuantity}} {{$pro->pUnit}}) </li>
									@endif
								@endforeach
							@endforeach
							</ol>
						</div>
						<div class="contentCard contentCardStatus col-md-3 center">
							<p class="head-card">{{$order[0]->oStatus}}</p>
						</div>
					</div>
				</div>
				@endif
			@endforeach
		@else
			<br>
			<h4 style="color: #BEBEBE;" align="center">ยังไม่มีรายการ</h4>
			<br>
		@endif
		</div>

	<!---------------------------status------------------------------------------------->
	@elseif (isset($_GET['รอชำระเงิน']))
	<h4 class="l-text10 t-left">
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รายการรอชำระเงินทั้งหมด &nbsp;&nbsp;{{$count}}&nbsp;&nbsp;รายการ<br><br>
	</h4>
	<div class="container">
		
		@if($count > 0)
			@foreach($orders as $index => $order)
				@if($order[0]->oStatus == 'กำลังตรวจสอบการชำระเงิน')
				
				<div class="card col-md-12">
					<div class="row">
						<div class="contentCard contentCardOrder col-md-3">
							<p class="head-card">ออเดอร์เลขที่ : {{$order[0]->oID}}</p>
							<p><i class="fa fa-user"></i> &nbsp;&nbsp;:&nbsp; {{$order[0]->oShipName}}</p>
							<p><i class="fa fa-calendar"></i></i> &nbsp;:&nbsp; {{$order[0]->oDate}}</p>
							<p style="color:red;"><i class="fa fa-hourglass-half" ></i></i> &nbsp;:&nbsp; {{$order[0]->oExp}} &nbsp;
							<?php
								$ts1 = strtotime($order[0]->oExp);
								$ts2 = strtotime(date("Y-m-d"));
								$diff = ($ts1 - $ts2)/3600/24;
								echo "( เหลือ : $diff วัน )"
							?></p><br>
							<input id="oID{{$index}}" type="hidden" value="{{$order[0]->oID}}">
							<a id="oID{{$index}}" href="#" class="pdf btn btn-outline-warning" style="margin-top:8px; ">ดูใบเสนอราคา</a></p>
							@foreach($evidences as $evidence)
								@if($evidence->oID == $order[0]->oID)
									
								<input id="evi{{$index}}" type="hidden" value="{{$evidence->eImg}}">								
								<a id="evi{{$index}}" href="#"  class="evi btn btn-warning" style="margin-top:8px;">ดูหลักฐานการชำระเงิน</a>								

								@endif
							@endforeach
						</div>
						<div class="contentCard col-md-6">
							<p class="head-card">รายการสินค้า</p>
							<ol>
							@foreach($order as $product)
								@foreach($products as $pro)
									@if($product->pID == $pro->pID)
										<li> {{$pro->tName}} ({{$pro->pBrand}}) {{$pro->pSize}} {{$pro->pThick}} &nbsp;&nbsp; (จำนวน : {{$product->dQuantity}} {{$pro->pUnit}}) </li>
									@endif
								@endforeach
							@endforeach
							</ol>
						</div>
						<div class="contentCard contentCardStatus col-md-3 center">
							<p class="head-card">{{$order[0]->oStatus}}</p>
						</div>
					</div>
				</div>
				@endif
				
				@if($order[0]->oStatus == 'รอชำระเงิน')
				<div class="card col-md-12">
					<div class="row">
						<div class="contentCard contentCardOrder col-md-3">
							<p class="head-card">ออเดอร์เลขที่ : {{$order[0]->oID}}</p>
							<p><i class="fa fa-user"></i> &nbsp;&nbsp;:&nbsp; {{$order[0]->oShipName}}</p>
							<p><i class="fa fa-calendar"></i></i> &nbsp;:&nbsp; {{$order[0]->oDate}}</p>
							<p style="color:red;"><i class="fa fa-hourglass-half" ></i></i> &nbsp;:&nbsp; {{$order[0]->oExp}} &nbsp;
							<?php
								$ts1 = strtotime($order[0]->oExp);
								$ts2 = strtotime(date("Y-m-d"));
								$diff = ($ts1 - $ts2)/3600/24;
								echo "( เหลือ : $diff วัน )"
							?></p><br>
							<input id="oID{{$index}}" type="hidden" value="{{$order[0]->oID}}">
							<a id="oID{{$index}}" class="pdf btn btn-warning" style="margin-top:8px; cursor:pointer;">ดูใบเสนอราคา</a></p>
						</div>
						<div class="contentCard col-md-6">
							<p class="head-card">รายการสินค้า</p>
							<ol>
							@foreach($order as $product)
								@foreach($products as $pro)
									@if($product->pID == $pro->pID)
										<li> {{$pro->tName}} ({{$pro->pBrand}}) {{$pro->pSize}} {{$pro->pThick}} &nbsp;&nbsp; (จำนวน : {{$product->dQuantity}} {{$pro->pUnit}}) </li>
									@endif
								@endforeach
							@endforeach
							</ol>

							<p align=right style="padding-right: 30px;">
								<input id="file{{$index}}" name="oID" type="hidden" value="{{$order[0]->oID}}">
								<a id="file{{$index}}" class="file btn btn-success" style="margin-left: 12px;margin-top:8px; color:white; cursor:pointer;" >ส่งหลักฐานการชำระเงิน</a>
							</p>

						</div>
						<div class="contentCard contentCardStatus col-md-3 center">
							<p class="head-card " style="text-align:center;">{{$order[0]->oStatus}}</p>
						</div>
					</div>
				</div>
				@endif
			@endforeach
		@else
			<br>
			<h4 style="color: #BEBEBE;" align="center">ยังไม่มีรายการ</h4>
			<br>
		@endif
	</div>

	<!---------------------------status------------------------------------------------->
	@else
		<h4 class="l-text10 t-left">
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รายการขอใบเสนอราคาทั้งหมด &nbsp;&nbsp;{{$count1}}&nbsp;&nbsp;รายการ<br><br>
		</h4>
		<div class="container">

		@if($count1 > 0)
			@foreach($orders as $index => $order)
				@if($order[0]->oStatus == 'อยู่ในระหว่างการขอใบเสนอราคา')
				<div class="card col-md-12">
					<div class="row">
						<div class="contentCard contentCardOrder col-md-3">
							<p class="head-card">ออเดอร์เลขที่ : {{$order[0]->oID}}</p>
							<p><i class="fa fa-user"></i> &nbsp;&nbsp;:&nbsp; {{$order[0]->oShipName}}</p>
							<p><i class="fa fa-calendar"></i></i> &nbsp;:&nbsp; {{$order[0]->oDate}}</p><br>
						</div>
						<div class="contentCard col-md-6">
							<p class="head-card">รายการสินค้า</p>
							<ol>
							@foreach($order as $product)
								@foreach($products as $pro)
									@if($product->pID == $pro->pID)
										<li> {{$pro->tName}} ({{$pro->pBrand}}) {{$pro->pSize}} {{$pro->pThick}} &nbsp;&nbsp; (จำนวน : {{$product->dQuantity}} {{$pro->pUnit}}) </li>
									@endif
								@endforeach
							@endforeach
							</ol>
						</div>
						<div class="contentCard contentCardStatus col-md-3 center">
							<p class="head-card">{{$order[0]->oStatus}}</p>
						</div>
					</div>
				</div>
				@endif
			@endforeach
		@else
			<br>
			<h4 style="color: #BEBEBE;" align="center">ยังไม่มีรายการ</h4>
			<br>
		@endif
		</div>
	@endif
    
	</div>
    

@endsection

@section('footer')
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/bootstrap/js/popper.js"></script>
	<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/select2/select2.min.js"></script>
	<script type="text/javascript" src="/assets/js/jquery-2.1.4.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script src="sweetalert2.min.js"></script>
	<link rel="stylesheet" href="sweetalert2.min.css">
	<script type="text/javascript">
		$(".selection-1").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});

		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect2')
		});

		$(".pdf").on('click', function() {
			oID = document.getElementById(this.id).value;
			window.location.assign("{{URL::to('/pdf?oID=')}}"+oID);
		});

		$(".confirm").on('click', function() {

			Swal.fire({
				title: 'ต้องการยืนยันใบเสนอราคานี้?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonText: 'ยกเลิก',
				cancelButtonColor: '#d33',
				confirmButtonText: 'ยืนยัน'
				}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire(
					'ยืนยันสำเร็จ!',
					'กรุณาชำระเงินและส่งหลักฐาน',
					'success'
					)
					oID = document.getElementById(this.id).value;
					window.location.assign("{{URL::to('/confirm?oID=')}}"+oID);
				}
			});
			
		});

		$(".confirmOrder").on('click', function() {

			Swal.fire({
				title: 'ต้องการยืนยันใบเสนอราคานี้?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonText: 'ยกเลิก',
				cancelButtonColor: '#d33',
				confirmButtonText: 'ยืนยัน'
				}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire(
					'ยืนยันสำเร็จ!',
					'กรุณาชำระเงินและส่งหลักฐาน',
					'success'
					)
					oID = document.getElementById(this.id).value;
					window.location.assign("{{URL::to('/adminQuotation/confirm?oID=')}}"+oID);
				}
			});

		});

		$(".cancel").on('click', function() {

			Swal.fire({
				title: 'ต้องการปฏิเสธใบเสนอราคานี้?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonText: 'ยกเลิก',
				cancelButtonColor: '#d33',
				confirmButtonText: 'ยืนยัน'
				}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire(
					'ปฏิเสธแล้ว!',
					'',
					'success'
					)
					oID = document.getElementById(this.id).value;
					window.location.assign("{{URL::to('/cancel?oID=')}}"+oID);
				}
			});

		});

		$(".file").on('click', function(e) {

			 oID = document.getElementById(this.id).value;
			 window.location.assign("{{URL::to('/evidence?oID=')}}"+oID);
		});

		$(".evi").on('click', function() {
			img = document.getElementById(this.id).value;
			path = "images/evidence/" + img;
			console.log(path);
			Swal.fire({
			title: "หลักฐานการชำระเงิน",
			imageUrl: path
			});
		});

		$(".bargain").on('click', function() {
			oID = document.getElementById(this.id).value;
			window.location.assign("{{URL::to('/adminQuotation?oID=')}}"+oID);
		});

	
		
	</script>
	
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/daterangepicker/moment.min.js"></script>
	<script type="text/javascript" src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/slick/slick.min.js"></script>
	<script type="text/javascript" src="js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/noui/nouislider.min.js"></script>
	<script type="text/javascript">
		/*[ No ui ]
	    ===========================================================*/
	    var filterBar = document.getElementById('filter-bar');

	    noUiSlider.create(filterBar, {
	        start: [ 50, 200 ],
	        connect: true,
	        range: {
	            'min': 50,
	            'max': 200
	        }
	    });

	    var skipValues = [
	    document.getElementById('value-lower'),
	    document.getElementById('value-upper')
	    ];

	    filterBar.noUiSlider.on('update', function( values, handle ) {
	        skipValues[handle].innerHTML = Math.round(values[handle]) ;
	    });
	</script>
	@if (Session('success'))
		<script type="text/javascript">
			Swal.fire({
				position: 'top-end',
				icon: 'success',
				title: 'สร้าใบเสนอราคาเรียบร้อยแล้ว',
				showConfirmButton: false,
				timer: 1500
			})
		</script>
	@endif
<!--===============================================================================================-->
	<script src="js/main.js"></script>
@endsection