&nbsp;&nbsp;&nbsp;

@if($order == $column and $dir == 'asc')
 <a href="?page=&order={{$column}}&dir=asc"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i></a>
@elseif($order == $column and $dir == 'desc')
 <a href="?page=&order={{$column}}&dir=desc"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i></a>
@else
 <a href="?page=&order={{$column}}&dir=desc"><i class="fa fa-bars" aria-hidden="true"></i></a>
@endif
