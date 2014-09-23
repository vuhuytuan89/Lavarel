@extends('content::_layout.default')

@section('main')
<div id="bb-full-team">
	@if ($dataIntro)
		@for($i = 1; $i <= count($departments); $i++)
				@if (isset($dataIntro[$departments[$i]]))
				<!-- MANAGERS -->
					<h3 class="dept-heading"><span><?php echo strtoupper(str_replace('_', ' ', $departments[$i])) ?></span></h3>
						<div class="grid-layout managers grid-layout4 clearafter">
						@for($j = 0; $j < count($dataIntro[$departments[$i]]); $j++)
							@if($j % 4 == 0)
								</div><div class="grid-layout managers grid-layout4 clearafter">
							@endif
								<div class="grid-col"><div class="grid-col_inner">
									<div class="staff-item">
										<div class="staff-avatar victor">
											<img alt="{{$dataIntro[$departments[$i]][$j]['fullname']}}" src="{{URL::to('/').'/upload/users/'.$dataIntro[$departments[$i]][$j]['avatar']}}">
										</div>
										<div class="staff-info">
											<h4 class="staff-title">{{$dataIntro[$departments[$i]][$j]['fullname']}}</h4>
											<p class="sub-title">{{$dataIntro[$departments[$i]][$j]['placement']}}</p>
											<p class="desc">{{$dataIntro[$departments[$i]][$j]['summary']}}</p>
										</div>
									</div>
							</div></div>
						@endfor
					</div>
			@endif
		@endfor
	@endif
</div>
@stop
