@extends('header-footer')

@section('header')
	<!-- Title Page -->
	<section class="bg-title-page p-t-50 p-b-40 flex-col-c-m" style="background-image: url(images/product.jpg);">
		<h2 class="l-text0 t-center" style="color:#3d3d3d;padding:30px;padding-left:100px;padding-right:100px;background-color: #cccccc;opacity: 0.85;">
			รายการสินค้า
		</h2>
	</section>


	<!-- Content page -->
	<section class="bgwhite p-t-55 p-b-65">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
					<div class="leftbar p-r-20 p-r-0-sm">
						<!--  -->
						<h4 class="m-text14 p-b-7">
							หมวดหมู่สินค้า
						</h4>

						<ul class="p-b-54">

							<div class="wrap-dropdown-content bo7 p-t-15 p-b-14">
								<a href="{{URL::to('/product')}}" class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
									รายการสินค้าทั้งหมด
								</a>
							</div>
							@foreach($groups as $group)
							<div class="wrap-dropdown-content bo7 p-t-15 p-b-14">
								<h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
									{{$group->gName}}
									<i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
									<i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
								</h5>
								<div class="dropdown-content dis-none p-t-15 p-b-23">
									@foreach($catagories as $cata)
										@if($group->gID == $cata->gID)
										<form action="{{URL::to('/search')}}" method="post">
										@csrf
											<input type="hidden" name="caID" value="{{$cata->caID}}"/>
											<button class="js-toggle-dropdown-content flex-sb-m cs-pointer s-text8 color0-hov trans-0-4" type="submit" name="name" value="{{$cata->caName}}">{{$cata->caName}}</button>
										</form>
										@endif
									@endforeach
								</div>
							</div>
							@endforeach
						</ul>
					</div>
				</div>

				<div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
					<!--  -->
					<div class="flex-sb-m flex-w p-b-35">
						<h2 class="l-text9 t-center" style="color:#fcc404">
							รายการสินค้าทั้งหมด
						</h2>

						<div class="s-text8 p-t-5 p-b-5">
							<form action="product" method="get">
								<div class="search-product pos-relative bo4 of-hidden">
									<input class="s-text7 size6 p-l-23 p-r-50" type="text" name="search" placeholder="ค้นหาสินค้า...">

									<button class="flex-c-m size5 ab-r-m color2 color0-hov trans-0-4">
										<i class="fs-12 fa fa-search" aria-hidden="true"></i>
									</button>
								</div>
							</form>
						</div>
					</div>

					<!-- Product -->
					@if(isset($_GET['search']))
					<?php
						$search = $_GET['search'];
						$servername = "us-cdbr-east-03.cleardb.com";
						$username = "b584ddc6783b50";
						$password = "7117e2cf";
						$dbname = "heroku_7f7e161f4166dd8";

						// Create connection
						$conn = new mysqli($servername, $username, $password, $dbname);
						mysqli_set_charset($conn, "utf8");
						
						// Check connection
						if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}

						$sql = "SELECT * FROM type WHERE tName LIKE '%$search%'";
						$result = mysqli_query($conn, $sql);
						
						mysqli_close($conn);
					?>
						
						@if(mysqli_num_rows($result) > 0)
							<span class="block2-price m-text6 p-r-5">
								ค้นหา &nbsp;&nbsp;" {{$search}} "<br>
							</span>
							<div>
								<br>
							</div>
							<div class="row">
								@while($row = mysqli_fetch_assoc($result))
									@foreach($products as $pro)
										@if($row['tID'] == $pro->tID)
										<?php
											$servername = "us-cdbr-east-03.cleardb.com";
											$username = "b584ddc6783b50";
											$password = "7117e2cf";
											$dbname = "heroku_7f7e161f4166dd8";
											$id = $pro->tID;
					
											// Create connection
											$conn = new mysqli($servername, $username, $password, $dbname);
											// Check connection
											if ($conn->connect_error) {
											die("Connection failed: " . $conn->connect_error);
											}

											$sql1 = "SELECT MAX(pPrice) as priceMax , MIN(pPrice) as priceMin
													FROM products
													WHERE tID = '$id'";
											$result1 = mysqli_query($conn, $sql1);
											
										?>
										<div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
											<!-- Block2 -->
											<!-- block2-labelnew block2-labelsale -->
											<!-- photo size 720x960 -->
											<div class="block2">
												<div class="block2-img wrap-pic-w of-hidden pos-relative">
													<img src="images/{{$pro->tImg}}" alt="IMG-PRODUCT" width="400" height="300">

													<div class="block2-overlay trans-0-4">
														<form action="{{URL::to('/product-detail')}}" method="post" class="block2-btn-addcart w-size1 trans-0-4">
															<!-- Button -->
															@csrf
															<input type="hidden" name="tID" value="{{$pro->tID}}"/>
															<button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
																ดูรายละเอียด
															</button>
														</form>
													</div>
												</div>

												<div class="block2-txt p-t-20">
													<a class="block2-name dis-block s-text3 m-text8 p-b-5">
														{{$pro->tName}}
													</a>
													<p style="color: #444444; font-size:16px;">
													@while($row1 = mysqli_fetch_assoc($result1))
														@if($row1['priceMin'] != $row1['priceMax'])
															{{$row1['priceMin']}} ~ {{$row1['priceMax']}} บาท
														@elseif($row1['priceMin'] != null)
															{{$row1['priceMin']}} บาท
														@endif
													@endwhile
													</p>
												</div>
											</div>
										</div>
										@endif
									@endforeach
								@endwhile
							</div>
						@else
							<span class="block2-price m-text6 p-r-5">
								ค้นหา &nbsp;&nbsp;" {{$search}} "<br>
							</span>

							<br>
							<h4 style="color: #BEBEBE;" align="center">ไม่พบผลลัพธ์</h4>
							<br>
						@endif  
					@else
						<div class="row">
							@if($caID == null && $gID == "no")
								@foreach($products as $pro)
								<?php
									$servername = "us-cdbr-east-03.cleardb.com";
									$username = "b584ddc6783b50";
									$password = "7117e2cf";
									$dbname = "heroku_7f7e161f4166dd8";
									$id = $pro->tID;
			
									// Create connection
									$conn = new mysqli($servername, $username, $password, $dbname);
									// Check connection
									if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
									}

									$sql1 = "SELECT MAX(pPrice) as priceMax , MIN(pPrice) as priceMin
											FROM products
											WHERE tID = '$id'";
									$result1 = mysqli_query($conn, $sql1);
									
								?>
								<div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
									<div class="block2">
										<div class="block2-img wrap-pic-w of-hidden pos-relative">
											<img src="images/{{$pro->tImg}}" alt="IMG-PRODUCT" width="400" height="300">

											<div class="block2-overlay trans-0-4">
												<form action="{{URL::to('/product-detail')}}" method="post" class="block2-btn-addcart w-size1 trans-0-4">
													<!-- Button -->
													@csrf
													<input type="hidden" name="tID" value="{{$pro->tID}}"/>
													<button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
														ดูรายละเอียด
													</button>
												</form>
											</div>
										</div>

										<div class="block2-txt p-t-20">
											<a class="block2-name dis-block s-text3 m-text8 p-b-5">
												{{$pro->tName}}
											</a>
											<p style="color: #444444; font-size:16px;">
											@while($row1 = mysqli_fetch_assoc($result1))
												@if($row1['priceMin'] != $row1['priceMax'])
													{{$row1['priceMin']}} ~ {{$row1['priceMax']}} บาท
												@elseif($row1['priceMin'] != null)
													{{$row1['priceMin']}} บาท
												@endif
											@endwhile
											</p>
										</div>
												
									</div>
								</div>
								@endforeach
							@elseif($caID != null && $gID == "no")
								@foreach($products as $pro)
								@if($caID == $pro->caID)
								<?php
									$servername = "us-cdbr-east-03.cleardb.com";
									$username = "b584ddc6783b50";
									$password = "7117e2cf";
									$dbname = "heroku_7f7e161f4166dd8";
									$id = $pro->tID;
			
									// Create connection
									$conn = new mysqli($servername, $username, $password, $dbname);
									// Check connection
									if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
									}

									$sql1 = "SELECT MAX(pPrice) as priceMax , MIN(pPrice) as priceMin
											FROM products
											WHERE tID = '$id'";
									$result1 = mysqli_query($conn, $sql1);
									
								?>
								<div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
									<!-- Block2 -->
									<!-- block2-labelnew block2-labelsale -->
									<!-- photo size 720x960 -->
									<div class="block2">
										<div class="block2-img wrap-pic-w of-hidden pos-relative">
											<img src="images/{{$pro->tImg}}" alt="IMG-PRODUCT" width="400" height="300">

											<div class="block2-overlay trans-0-4">
												<form action="{{URL::to('/product-detail')}}" method="post" class="block2-btn-addcart w-size1 trans-0-4">
													<!-- Button -->
													@csrf
													<input type="hidden" name="tID" value="{{$pro->tID}}"/>
													<button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
														ดูรายละเอียด
													</button>
												</form>
											</div>
										</div>

										<div class="block2-txt p-t-20">
											<a class="block2-name dis-block s-text3 p-b-5">
												{{$pro->tName}}
											</a>
											<p style="color: #444444; font-size:16px;">
											@while($row1 = mysqli_fetch_assoc($result1))
												@if($row1['priceMin'] != $row1['priceMax'])
													{{$row1['priceMin']}} ~ {{$row1['priceMax']}} บาท
												@elseif($row1['priceMin'] != null)
													{{$row1['priceMin']}} บาท
												@endif
											@endwhile
											</p>
										</div>
									</div>
								</div>
								@endif
								@endforeach

							@else
								@foreach($products_search as $pro)
									<?php
										$servername = "us-cdbr-east-03.cleardb.com";
										$username = "b584ddc6783b50";
										$password = "7117e2cf";
										$dbname = "heroku_7f7e161f4166dd8";
										$id = $pro->tID;
				
										// Create connection
										$conn = new mysqli($servername, $username, $password, $dbname);
										// Check connection
										if ($conn->connect_error) {
										die("Connection failed: " . $conn->connect_error);
										}

										$sql1 = "SELECT MAX(pPrice) as priceMax , MIN(pPrice) as priceMin
												FROM products
												WHERE tID = '$id'";
										$result1 = mysqli_query($conn, $sql1);
										
									?>
									<div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
										<!-- Block2 -->
										<!-- block2-labelnew block2-labelsale -->
										<!-- photo size 720x960 -->
										<div class="block2">
											<div class="block2-img wrap-pic-w of-hidden pos-relative">
												<img src="images/{{$pro->tImg}}" alt="IMG-PRODUCT" width="400" height="300">

												<div class="block2-overlay trans-0-4">
													<form action="{{URL::to('/product-detail')}}" method="post" class="block2-btn-addcart w-size1 trans-0-4">
														<!-- Button -->
														@csrf
														<input type="hidden" name="tID" value="{{$pro->tID}}"/>
														<button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
															ดูรายละเอียด
														</button>
													</form>
												</div>
											</div>

											<div class="block2-txt p-t-20">
												<a class="block2-name dis-block s-text3 p-b-5">
													{{$pro->tName}}
												</a>
												<p style="color: #444444; font-size:16px;">
												@while($row1 = mysqli_fetch_assoc($result1))
													@if($row1['priceMin'] != $row1['priceMax'])
														{{$row1['priceMin']}} ~ {{$row1['priceMax']}} บาท
													@elseif($row1['priceMin'] != null)
														{{$row1['priceMin']}} บาท
													@endif
												@endwhile
												</p>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						</div>
					@endif
					

				</div>
			</div>
		</div>
	</section>
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
	<script type="text/javascript">
		$(".selection-1").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});

		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect2')
		});
	</script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/daterangepicker/moment.min.js"></script>
	<script type="text/javascript" src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/slick/slick.min.js"></script>
	<script type="text/javascript" src="js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/sweetalert/sweetalert.min.js"></script>
	<!-- <script type="text/javascript">
		$('.block2-btn-addcart').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to cart !", "success");
			});
		});

		$('.block2-btn-addwishlist').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");
			});
		});
	</script> -->

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
<!--===============================================================================================-->
	<script src="js/main.js"></script>
@endsection