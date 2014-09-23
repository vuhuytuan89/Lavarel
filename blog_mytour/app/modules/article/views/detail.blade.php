@extends('content::_layout.default')

@section('main')
	<div class="blog_detail">
		<div class="blog_detail_top">
			<p class="title">{{$dataArticle['art_title']}}</p>
			<div class="status">
				<span class='st_facebook_hcount' displayText='Facebook'></span>
				<span class='st_twitter_hcount' displayText='Tweet'></span>
				<span class='st_googleplus_hcount' displayText='Google +'></span>
				<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
				<script type="text/javascript">stLight.options({publisher: "994e439b-6966-4dd4-8ef9-fd647616d111", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
				<div class="time">{{date('d/m/Y', $dataArticle['art_date_created'])}} {{date('H:i',
					$dataArticle['art_date_created'])}}
				</div>
				<div class="clrb"></div>
			</div>
		</div>
		<div class="blog_detail_ct">
			{{$dataArticle['art_detail']}}
		</div>
		<div class="tag_box">
			<span class='st_facebook_hcount' displayText='Facebook'></span>
			<span class='st_twitter_hcount' displayText='Tweet'></span>
			<span class='st_googleplus_hcount' displayText='Google +'></span>
			<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
			<script type="text/javascript">stLight.options({publisher: "994e439b-6966-4dd4-8ef9-fd647616d111", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
			<div class="clrb"></div>
		</div>
	</div>
	<div id="comments">
	</div>
	<div id="respond">
			<h3 id="reply-title" class="titlereply"><strong>Bình luận</strong>
			</h3>
			<div class="clrb"></div>
			<form method="post" id="commentform">
				<div>
					<p class="comment-form-comment"><label for="comment">Nội dung
							(<span class="required">*</span> )</label><textarea id="comment" name="comment" cols="45" rows="8" class="textareacomment" ></textarea>
					</p>
					<p class="form-submit text-right">
						<input name="submit" onclick="clickSubmit()" type="button" id="submit" value="Trả lời" class="btn_blue" />
						<input name="art_id" type="hidden" id="art_id" value="{{$dataArticle['art_id']}}" />
					</p>
				</div>
			</form>
		</div>
		{{ HTML::script('assets/js/ckeditor/ckeditor.js') }}
		<script type="text/javascript">
				CKEDITOR.replace( 'comment', {
					toolbar: [
						{ name: 'document', items: [ 'Source', '-', 'Preview', '-', 'Templates', '-', 'Undo', 'Redo'  ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
						// '/',
						{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
						{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
						{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat' ] },
						{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor' ] },
						{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
					]
				});
		</script>
	<script type="text/javascript">
			function quoteComment(usr_id, com_id){
				var username ="{{Session::get('infusr')}}";
				if(username){
					var html = '<blockquote>' + $('#comment-detail'+com_id).html() + '</blockquote><p></p>';
					$('#com_quote_id').val(com_id);
					CKEDITOR.instances['comment'].insertHtml(html);
					$("a[id^='cancelreply_']").filter(function () {
						$(this).hide();
					});
					$("a[id^='reply_']").filter(function () {
						$(this).show();
					});
					$('#reply_'+com_id).hide();
					$('#cancelreply_'+com_id).show();
					$("html, body").animate({ scrollTop: $('#respond').offset().top }, 1000);
				}else{
						alert('Bạn hãy đăng nhập để bình luận');
					}
			}
			function CancelquoteComment(com_id){
				$('#com_quote_id').val(0);
				CKEDITOR.instances['comment'].setData('');
				$('#cancelreply_'+com_id).hide();
				$('#reply_'+com_id).show();
			}

			function clickSubmit(){
				var id_usr ="{{Session::get('infusr_id')}}";
				var art_id = $('#art_id').val();
				var com_quote_id = $('#com_quote_id').val();
				var content = CKEDITOR.instances['comment'].getData()
				if(id_usr){
					if(content != ''){
						$.ajax({
							url: "{{URL::to('/ajaxloadcomment')}}",
							type: "post",
							data: {com_art_id: art_id, com_detail: content, id_usr: id_usr, com_quote_id: com_quote_id },
							success: function(html){
								CKEDITOR.instances['comment'].insertHtml('');
								$('.load_comment').remove();
								$("#comments").html(html);
				    			var last_id_comment = $('#last_id_comment').val();
			    				 if(last_id_comment != 0){
									$("html, body").animate({ scrollTop: $('#comment'+last_id_comment).offset().top - 50 }, 1000);
								}
							},
							error:function(){
								$("#listcomment").html('Không có comment nào');
							}
						});
					}else{
						alert('Bạn hãy nhập nội dung bình luận');
					}
				}else{
					alert('Bạn hãy đăng nhập để bình luận');
				}
			}
			//paging ajax comment
				var id_art = {{$dataArticle['art_id']}};
        		$('#comments').load('{{URL::to("/ajaxloadcomment")}}', {id_art: id_art});
		</script>
@stop
