<?php 
$url = $url."?";
$query = $_GET;
$num_page = ceil($total/$limit) > 6 ? 6 : ceil($total/$limit);
?>
<div class="d-flex flex-stack flex-wrap pt-10">
	<div class="fs-6 fw-semibold text-gray-700">Showing {{($page-1)*$limit +1 }} to {{$page*$limit}} of {{$total}} entries</div>
	<!--begin::Pages-->
	<ul class="pagination">
		<?php $query['page'] = $page>1 ? $page-1 : 1?>
		<li class="page-item previous">
			<a href="{{$url.http_build_query($query)}}" class="page-link">
				<i class="previous"></i>
			</a>
		</li>
		@for($i=1;$i<$num_page+1;$i++)
			@if($page<3)
			<?php $query['page'] = $i?>
			<li class="page-item {{$page==$i ? 'active' : ''}}">
				<a href="{{$url.http_build_query($query)}}" class="page-link">{{$i}}</a>
			</li>
			@else
			<?php $query['page'] = $i+$page-3?>
			<li class="page-item {{$page==$i+$page-3 ? 'active' : ''}}">
				<a href="{{$url.http_build_query($query)}}" class="page-link">{{$page+$i-3}}</a>
			</li>
			@endif
		@endfor
		<?php $query['page'] = $page+1?>
		<li class="page-item next">
			<a href="{{$url.http_build_query($query)}}" class="page-link">
				<i class="next"></i>
			</a>
		</li>
	</ul>
	<!--end::Pages-->
</div>