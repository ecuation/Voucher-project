<?php
Route::model('shop', 'Shop');
Route::model('voucher', 'Voucher');
Route::model('user', 'User');


Route::get('/', function()
{
	return Redirect::to('login');
});

Route::get('login', function(){
	return View::make('backoffice.login');
});

Route::get('forgot', function()
{
	return View::make('backoffice.forgot');
});

Route::post('forgot', function()
{
	$rules = array('email' => 'email|required');
	$validator = Validator::make(Input::only('email'),$rules);

	if(!$validator->fails())
	{
		$user = User::where('email', '=', Input::get('email'))->get();


		if(!$user->isEmpty())
		{
			Mail::send('emails.auth.reminder', array('user' => $user), function($message)
			{
			    $message->to(Input::get('email'),'Refill 24')->subject('Recordatorio de contraseña.');
			});

			return Redirect::to('login')->with('success','Hemos enviado tu contraseña por correo electrónico.');
		}else{
			return Redirect::back()->with('error', 'Usario incorrecto!');
		}
			
	}else{
		return Redirect::back()->withErrors($validator);
	}
});

//login
Route::post('login', function()
{
	$rules = array(	'email' => 'required|email',
					'password' => 'required');

	$validator = Validator::make(Input::all(), $rules);

	if(!$validator->fails())
	{
		if(Auth::attempt(Input::only('email', 'password')))
		{
			if(Auth::user()->is_admin)
				return Redirect::to('admin/panel');

			return Redirect::to('shops');
		}else{
			return Redirect::back()->withInput()->with('login_error', "Invalid credentials");
		}
			
	}else{
		return Redirect::back()->withInput()->withErrors($validator);
	}
});

//logout
Route::get('logout', function(){
	Session::flush();
	Auth::logout();
	return Redirect::to('login')->with('success_message', 'Sesión finalizada');
});

//user
Route::group(array('before' => 'auth'), function()
{
	Route::get('admin/vouchers', 'AdminController@showVouchersPage');
	Route::get('admin/firstPreview/{voucher}', 'AdminController@firstPreview');
	Route::get('shops', 'ShopController@shops');
	Route::any('shop/{shop}','ShopController@shop');
	Route::post('customer/edit_name', function(){

		$id = intval($_GET['id']);
		$customer = Customer::find($id);
		$customer->customer_name = $_GET['value'];
		$customer->save();
	});

	Route::post('suscription/edit_reuses', function(){
		$id = intval($_GET['id']);
		$suscription = Suscription::find($id);
		$suscription->reuses = intval($_GET['value']);
		$suscription->save();
	});

	Route::post('suscription/edit_uses/', function(){
		$id = intval($_GET['id']);
		$suscription = Suscription::find($id);
		$suscription->is_used = intval($_GET['value']);
		$suscription->save();
	});


	Route::get('orderBy', function()
	{
		$order = (Session::get('orderBy') == 'asc') ? 'desc' : 'asc';
		Session::put('orderBy', $order);
		
		return Redirect::back();
	});
});


//admin
Route::group(array('before' => 'auth|admin'), function ()
{	
	Route::get('admin/panel', function (){
		return View::make('admin.admin');
	});

	Route::get('admin/voucher/new', 'AdminController@newVoucherView');
	Route::get('admin/voucher/edit/{voucher}','AdminController@editVoucherView');

	Route::post('admin/voucher_process', 'AdminController@create');
	Route::put('admin/voucher_process/{voucher}', 'AdminController@edit');

	// Route::get('admin/vouchers', 'AdminController@showVouchersPage');

	Route::get('admin/delete/{voucher}', 'AdminController@delteConfirmation');

	// Route::get('admin/firstPreview/{voucher}', 'AdminController@firstPreview');

	Route::delete('admin/voucher_process/{voucher}', 'AdminController@delete');

	Route::get('admin/reminder/{voucher}', 'AdminController@sendRemainders');


	Route::post('admin/update_note', function(){
		$id = intval($_GET['id']);
		$voucher = Voucher::find($id);
		$voucher->note = trim($_GET['value']);
		$voucher->save();
	});

	Route::get('admin/settings/', function (){
		return View::make('admin/settings');
	});

	//gestion usuarios

	Route::get('admin/users/', 'AdminController@users');
	Route::post('admin/user_process', 'AdminController@new_user');
	Route::put('admin/user_process/{user}', 'AdminController@edit_user');
	Route::delete('admin/user_process/{user}', 'AdminController@deleteUser');


	Route::get('admin/user/create', function(){
		$user = new User;
		return View::make('admin.user_form')->with('user', $user)->with('method', 'post');
	});

	Route::get('admin/user/edit/{user}', 'AdminController@edit_user_view');

	Route::get('admin/user/delete/{user}', function(User $user){
		return View::make('admin.user_form')->with('user', $user)->with('method', 'delete');
	});


	//gestion tiendas


	Route::get('admin/shops','AdminController@shopsView');

	Route::post('admin/shop_process', 'AdminController@new_shop');
	Route::put('admin/shop_process/{shop}', 'AdminController@edit_shop');
	Route::delete('admin/shop_process/{shop}', 'AdminController@deleteShop');


	Route::get('admin/shop/create', function(){
		$shop = new Shop;
		return View::make('admin.shop_form')->with('shop', $shop)->with('method', 'post');
	});

	Route::get('admin/shop/edit/{shop}', 'AdminController@edit_shop_view');

	Route::get('admin/shop/delete/{shop}', function(Shop $shop){
		return View::make('admin.shop_form')->with('shop', $shop)->with('method', 'delete');
	});


});


//customer
Route::get('customer/vouchers', 'CustomerController@showVouchersPage');

Route::get('customer/legal_agreements', function(){
	return View::make('frontoffice.legal_agreements');
});

Route::post('customer/suscription', 'CustomerController@suscribe');

Route::post('customer/recommend', 'CustomerController@recommend');

Route::get('customer/voucher/{voucher}', function(Voucher $voucher){
	return View::make('frontoffice.voucher')->with('voucher', $voucher);
});

Route::get('customer/unsubscribe', function (){
	return View::make('frontoffice.unsubscribe');
});

Route::post('customer/unsubscribe', function(){
	$rules = array('email'=>'required|email');
	$validator = Validator::make(Input::all(), $rules);

	if(!$validator->fails())
	{
		$customer = Customer::where('email', '=', Input::get('email'))->first();

		if($customer){
			$customer->delete();
			Mail::send('emails.auth.unsubscribe',array('email' => Input::get('email')), function ($message){
				$message->to(Input::get('email'), 'Invitado')->subject('Confirmación de baja.');
			});

			return Redirect::to('customer/vouchers')->with('success', 'Proceso finalizado con éxito!');
		}else{
			return Redirect::back()->with('error', 'Este usuario ya no consta dado de alta.');
		}
	}else{
		return Redirect::back()->with('error', 'Email erróneo');
	}

});

Route::get('customer/confirmation', function(){
	return View::make('frontoffice.confirmation');
});
Route::get('customer/recommend', function(){
	return View::make('frontoffice.confirmation');
});

Route::get('about', function(){
	return View::make('frontoffice.about');
});

Route::get('franchise', function(){
	return View::make('frontoffice.franchise');
});

Route::get('refilling', function(){
	return View::make('frontoffice.refilling');
});

Route::get('ink', function(){
	return View::make('frontoffice.ink');
});

Route::get('toner', function(){
	return View::make('frontoffice.toner');
});

Route::get('cartridges', function(){
	return View::make('frontoffice.cartridges');
});

Route::get('contact', function(){
	return View::make('frontoffice.contact');
});

Route::get('faq', function(){
	return View::make('frontoffice.faq');
});

Route::get('terms_of_use', function(){
	return View::make('frontoffice.terms_of_use');
});

Route::get('privacy_policy', function(){
	return View::make('frontoffice.privacy_policy');
});

App::missing(function($exception)
{
    return Response::view('errors.missing', array(), 404);
});


// Route::group(array('before' => 'auth|shopSelected'), function(){
// 	Route::get('user', function(){
// 		return View::make('backoffice.user');
// 	});


// });

//end user
// App::missing(function($exception)
// {
//     return Response::view('errors.missing', array(), 404);
// });

