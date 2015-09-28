@extends('email_master_back')

@section('title')
  Tu amig@ {{$name}} cree que nuestras ofertas/promociones pueden resultarte interesantes, échales un vistazo!
@stop


@section('extras')
      <table class="col380" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 380px;">  
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="bodycopy">
                  Para más información pincha en el enlace que te indicamos a continuación y aprovecha nuestras geniales ofertas/promociones.
                </td>
              </tr>
              <tr>
                <td style="padding: 20px 0 0 0;">
                  <table class="buttonwrapper" bgcolor="#e05443" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="button" height="45">
                        <a href="{{url('customer/vouchers')}}">Ver mas</a>
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
