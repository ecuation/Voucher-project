@extends('email_master_back')

@section('title')
  {{$title}}
@stop

@section('description1')
<tr>
  <td class="bodycopy">
    {{$brief_description}}
  </td>
</tr>
@stop

@section('main_image')
      <tr>
        <td class="innerpadding borderbottom">
          @if(empty($image))
            <img class="fix" src="{{asset('images/default_voucher.jpg')}}" width="100%" border="0" alt="voucher_image" />
          @else
            <img class="fix" src="{{asset('voucher_img/'.$image)}}" width="100%" border="0" alt="voucher_image" />
          @endif
        </td>
      </tr>
@stop

@section('extras')
      <table class="col380" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 380px;">  
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="bodycopy">
                  Para más información pincha en el enlace que te indicamos a continuación y aprovéchate de ésta y otras ofertas.
                </td>
              </tr>
              <tr>
                <td style="padding: 20px 0 0 0;">
                  <table class="buttonwrapper" bgcolor="#e05443" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="button" height="45">
                        <a href="{{url('customer/voucher/'.$id)}}">Ver mas</a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
@stop




@section('optional_text')
<!-- <tr>
  <td class="innerpadding bodycopy">
      Este texto puede ser opcional en algunos casos...  Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus adipiscing felis, sit amet blandit ipsum volutpat sed. Morbi porttitor, eget accumsan dictum, nisi libero ultricies ipsum, in posuere mauris neque at erat.
  </td>
</tr> -->
@stop


@section('legal')
	De acuerdo con la Ley Orgánica 15/1999, de 13 de diciembre, de Protección de Datos de Carácter Personal, le recordamos que puede dejar de recibir las ofertas seleccionadas accediendo al link del final de pagina.
@stop