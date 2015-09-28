@extends('email_master')

@section('content')
      <tr>
        <td class="innerpadding">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="h2">
                ¡Gracias por inscribirte!
              </td>
            </tr>
            <tr>
              <!-- <td class="bodycopy">
                Te has inscrito con la siguiente dirección de correo: maxsus60@gmail.com.
                <br />
                Para recibir nuestras promociones 
                Te informaremos sobre nuestras futuras ofertas que puedan interesarte.

              </td> -->
              <td class="bodycopy">
                Te has inscrito con la siguiente dirección de correo electrónico:<br /> {{$email}}.
                <br />
                No te pierdas nuestras futuras e interesantes ofertas. Te mantendremos informado.
                <!-- Para recibir nuestras promociones 
                Te informaremos sobre nuestras futuras ofertas que puedan interesarte. -->

              </td>
            </tr>
          </table>
        </td>
      </tr>
      

      <!-- image -->
      <!-- <tr>
       
        <td class="voucher-image">
          <img class="fix" src="images/wide.png" width="100%" border="0" alt="" />
        </td>
       
      </tr> -->
      <!-- end image -->

      <!-- voucher  -->        
      <tr>
        <td class="innerpadding voucher">
          <table width="115" align="left" border="0" cellpadding="0" cellspacing="0">  
            <tr>
              <td height="115" style="padding: 0 20px 20px 0;">
                <img class="fix" src="{{asset('images/article1.png')}}" width="115" height="115" border="0" alt="" />
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
            <table width="380" align="left" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="col380" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 380px;">  
            <tr>
              <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="h2">
                      {{$voucher->title}}
                    </td>
                  </tr>
                  <tr>
                    <td class="bodycopy">Presenta éste código impreso</td>
                  </tr>
                  <tr>
                    <td class="h2" style="padding: 10px 0 0 4em;">
                      {{$voucher->voucher_code}}
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 10px 0 0 0;">
                        <tr>
                          <td style="padding: 20px 0 0 0;">
                            <table class="buttonwrapper" bgcolor="#e05443" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td class="button" height="45">
                                  <a href="{{url('customer/voucher/'.$voucher->id)}}">Más info</a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                    </td>
                    <td style="padding: 10px 0 0 0;">
                        <tr>
                          <!-- <td class="button" height="45">
                            <a href="#">Claim yours!</a>
                          </td> -->
                          <td class="bodycopy">Válido desde el {{StringFormat::formatTimestampt('d/m/Y', $voucher->starts_at)}} hasta {{StringFormat::formatTimestampt('d/m/Y', $voucher->finishes_at)}}.</td>
                        </tr>
                        <tr>
                          <td class="bodycopy">Infórmate sobre condiciones y tiendas adheridas.</td>
                        </tr>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
                </td>
              </tr>
          </table>
          <![endif]-->
        </td>
        
      </tr>
      <!-- end voucher -->


    <br><br><br>

@stop