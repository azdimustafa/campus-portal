<img 
src="{{ config("constants.staff_img") }}{{ $id }}.jpg" 
class="img-circle img-thumbnail"
alt="" 
style="width:{{ $width ?? '60' }}px;" 
onerror="this.onerror=null; this.src='{{ asset('img/avatar.png') }}'">