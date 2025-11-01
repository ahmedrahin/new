
<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head>
        
		<title></title>
		<meta charset="utf-8" />

		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank">
		
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Wrapper-->
			<div class="d-flex flex-column flex-column-fluid">
				
				<!--begin::Body-->
				<div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
					<!--begin::Email template-->
					<style>
                        html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }
                        li{display: inline;list-style: none;padding: 0 2px;}
                        li i {font-size: 18px !important;}
                    </style>
					<div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
						<div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
							<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
								<tbody>
									<tr>
										<td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
											<!--begin:Email content-->
											<div style="text-align:center; margin:0 60px 34px 60px">
												<!--begin:Logo-->
												<div style="margin-bottom: 10px">
													<a href="{{url('/')}}" rel="noopener" target="_blank">
														<img alt="Logo" src="{{config('app.logo-dark')}}" style="height: 35px" />
													</a>
												</div>
												<!--end:Logo-->
												
												<div style="font-size: 14px; font-weight: 500; margin-bottom: 42px; font-family:Arial,Helvetica,sans-serif">
													<p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Recived a new order</p>
												</div>

                                                <div>
													<!--begin:Title-->
													<h3 style="text-align:left; color:#181C32; font-size: 16px; font-weight:600; margin-bottom: 22px">Customer Information</h3>
													<!--end:Title-->
													<!--begin:Items-->
													<div style="padding-bottom:9px">
														<!--begin:Item-->
														<div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500; margin-bottom:8px">
															<div style="font-family:Arial,Helvetica,sans-serif">Customer Name:</div>
															<div style="font-family:Arial,Helvetica,sans-serif">{{$order->name}}</div>

														</div>
														<div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500; margin-bottom:8px">
															<div style="font-family:Arial,Helvetica,sans-serif">Phone No:</div>
															<div style="font-family:Arial,Helvetica,sans-serif">{{$order->phone}}</div>

														</div>
														
														<div class="separator separator-dashed" style="margin:15px 0; border-color: #dbdfe9;"></div>
														
													</div>
												</div>
												
												<div style="margin-bottom: 15px">
													<!--begin:Title-->
													<h3 style="text-align:left; color:#181C32; font-size: 16px; font-weight:600; margin-bottom: 22px">Order Information</h3>

													<div style="padding-bottom:9px">
														<div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500; margin-bottom:8px">
															<div style="font-family:Arial,Helvetica,sans-serif">Order-id:</div>
															<div style="font-family:Arial,Helvetica,sans-serif">#{{$order->id}}</div>

														</div>
														<div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500; margin-bottom:8px">
															<div style="font-family:Arial,Helvetica,sans-serif">Total Quantity:</div>
															<div style="font-family:Arial,Helvetica,sans-serif">{{$order->orderItems->sum('quantity')}}</div>

														</div>
                                                        <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500; margin-bottom:8px">
															<div style="font-family:Arial,Helvetica,sans-serif">Grand Total:</div>
															<div style="font-family:Arial,Helvetica,sans-serif">৳{{$order->grand_total}}</div>

														</div>
                                                        <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500; margin-bottom:8px">
															<div style="font-family:Arial,Helvetica,sans-serif">Order Date:</div>
															<div style="font-family:Arial,Helvetica,sans-serif">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</div>

														</div>
													</div>
													
												</div>
												
												<a href="{{route('order-management.order.show',$order->id)}}" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">Order Details</a>
												<!--begin:Action-->
											</div>
											<!--end:Email content-->
										</td>
									</tr>
									
									<tr>
										<td align="center" valign="center" style="text-align:center; padding-bottom: 20px;">
											@if( !is_null(config('app.facebook')) )
                                                <li>
                                                <a href="{{config('app.facebook')}}"><i class="bi bi-facebook"></i></a>
                                                </li>
                                            @endif
                                            @if( !is_null(config('app.whatsapp')) )
                                                <li>
                                                <a href="{{config('app.whatsapp')}}"><i class="bi bi-whatsapp"></i></a>
                                                </li>
                                            @endif
                                            @if( !is_null(config('app.instra')) )
                                                <li>
                                                <a href="{{config('app.instra')}}"><i class="bi bi-instagram"></i></a>
                                                </li>
                                            @endif
                                            @if( !is_null(config('app.youtube')) )
                                                <li>
                                                <a href="{{config('app.youtube')}}"><i class="bi bi-youtube"></i></a>
                                                </li>
                                            @endif
										</td>
									</tr>
									<tr>
										<td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
											<p>&copy; Copyright {{config('app.name')}}.</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<!--end::Email template-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Wrapper-->
		</div>
		
	</body>
	<!--end::Body-->
</html>