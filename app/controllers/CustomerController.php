<?php 
class CustomerController extends BaseController
{

	public function suscribe()
	{
		$rules = array(	'email' => 'email|required', 'voucher' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		$vouchers = Input::get('voucher');

		if(empty($vouchers))
			return Redirect::back()->with('error', 'No has seleccionado ninguna oferta a la cual apuntarte!')->withInput();

		if(!$validator->fails())
		{
			$customer = Customer::firstOrCreate(array('email' => Input::get('email')));
			
			$this->sendVouchersByEmail($customer, $vouchers);

			return Redirect::to('customer/confirmation')->with('success','Gracias, tus cupones se han enviado satisfactoriamente a la dirección de correo electrónico que nos has 
				facilitado. Si no encuentras tu oferta/promoción, no olvides revisar tu bandeja de "correo no deseado".');	
		}
		
		return Redirect::back()->with('error','Introduce un email para continuar.')->withInput();
	}


	private function sendVouchersByEmail($customer, $vouchers)
	{
		for ($i=0; $i < count($vouchers) ; $i++)
		{ 
			$suscription = Suscription::firstOrCreate(array('customer_id' => $customer->id, 'voucher_id' => $vouchers[$i]));

			Mail::send('emails.auth.subscription', array('email'=>Input::get('email'), 'voucher'=> Voucher::find($vouchers[$i])), function ($message){
				$message->to(Input::get('email'), ' ')->subject('Gracias por suscribirte! Aquí tienes tu código promocional.');
			});
		}
	}

	public function showVouchersPage()
	{
		$voucher = new Voucher;
		$vouchers = Voucher::orderBy('id','ASC')->where('is_active', '=', 1)->where('finishes_at', '>=', new DateTime('today'))->paginate(10);

		return View::make('frontoffice.vouchers')->with('vouchers', $vouchers)->with('voucher', $voucher);
	}


	public function recommend()
	{
		$rules = array('email' => 'required|email', 'name'=>'required');
		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails()){
			Mail::send('emails.auth.recommend',array('name' => Input::get('name'), 'email' => Input::get('email')), function ($message){
				$message->to(Input::get('email'), ' ')->subject('Tu amig@ '.Input::get('name').' te recomienda nuestras ofertas/promociones.');
			});
			return Redirect::to('customer/vouchers')->with('success', 'Recomendación enviada con éxito!');
		}else{
			return Redirect::back()->with('error', 'Campos incorrectos!');
		}
	}
}

?>