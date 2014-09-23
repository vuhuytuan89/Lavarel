@if($dataComment)
	@foreach($dataComment as $com)
	<li class="comment" id="comment{{$com['com_id']}}">
		<img alt='' src="{{URL::to('/').'/upload/users/'.$com['avatar']}}" class='avatar avatar-48 photo' height='48' width='48' />
		<div class="contentcomment">
			<h4><a href="{{URL::to('/').'/blogger/profile/'.$com['username']}}" rel='external nofollow' class='url'>{{$com['username']}}</a></h4>
			<span class="datecomment">{{date('d/m/Y', $com['com_date_created'])}} - {{date('H:i', $com['com_date_created'])}}</span>
			<div class="clrb"></div>
			@if(isset($com['com_quote_detail']) && isset($com['blogger_quote']))
							<div class="quote-comment">
								<p class="blogger_quote">{{$com['blogger_quote']}}</p>
								{{$com['com_quote_detail']}}
							</div>
						@endif
			<div class="comment-detail" id="comment-detail{{$com['com_id']}}">{{$com['com_detail']}}</div>
			@if($com['usr_id'] != Session::get('infusr_id'))
			<!-- .comment-author .vcard -->
			<div class="clear"></div>
			<a class='comment-reply-link' style="display: none" id="cancelreply_{{$com['com_id']}}" href="javascript:;" onclick="return CancelquoteComment({{$com['com_id']}})">Hủy trả lời với trích dẫn</a>
			<a class='comment-reply-link' href="#respond" id="reply_{{$com['com_id']}}" onclick="return quoteComment({{$com['usr_id']}}, {{$com['com_id']}})">Trả lời với trích dẫn</a>
			@endif
			<div class="clear"></div>
		</div>
		<!-- .comment-author .vcard -->
		<div class="clrb"></div>
	</li>
	@endforeach
	<input type="hidden" name="count_comment" id="count_comment" value="{{$count_comment}}">
@endif
