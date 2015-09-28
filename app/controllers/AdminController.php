<?php 
class AdminController extends ControllerCore
{
	private $voucher;

	public function create()
	{

		$rules = array('title' => 'required|max:100', 'img' => 'image|mimes:jpeg,jpg,svg,png,gif',
						'starts_at' => 'date_format:"Y-m-d"|required|after:today',
						'finishes_at' => 'required|date_format:"Y-m-d"|after:today');
		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails())
		{
			$file = Input::file('img');
			$this->voucher = Voucher::create(Input::all());
			$this->voucher->voucher_code = strtoupper(str_random(5));

			if(Input::hasFile('img'))
				$this->voucher->img = $this->uploadImage($file);

			$this->setCheckboxesAndMailingState($this->voucher);
			$this->voucher->save();

			return Redirect::to('admin/vouchers')->with('success','Voucher created successfully!');
		}

		return Redirect::back()->withInput()->withErrors($validator);

	}

	public function edit(Voucher $voucher)
	{
		$this->voucher = $voucher;

		$rules = array('title' => 'required|max:100', 'img' => 'image|mimes:jpeg,jpg,svg,png,gif',
						'starts_at' => 'date_format:"Y-m-d"|required',
						'finishes_at' => 'required|date_format:"Y-m-d"');

		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails())
		{
			$file = Input::file('img');
			$voucher->update(Input::except('img'));

			if(Input::hasFile('img'))
				$voucher->img = $this->uploadImage($file);

			$this->setCheckboxesAndMailingState();
			
			$voucher->save();
			return Redirect::to('admin/vouchers')->with('success','Voucher updated successfully!');
		}

		return Redirect::back()->withInput()->withErrors($validator);

	}

	private function setCheckboxesAndMailingState()
	{
		if(Input::has('sended_through_db')){
			$this->dbMailingSender();
			$this->voucher->sended_through_db = true;
		}
			
		if(Input::has('mailing_box')){
			$this->mailingBoxSender($this->voucher);
			$this->voucher->sended_through_mailing_box = true;
		}
			

		if(!Input::has('is_active'))
				$this->voucher->is_active = 0;
	}

	private function mailingBoxSender()
	{
		$emails = explode(',', Input::get('mailing_box'));
		$title = $this->voucher->title;

		for($i=0; $i<count($emails); $i++)
		{
			$subject = 'Hemos añadido una nueva oferta para ti, no te la pierdas!.';
			$email = trim($emails[$i]);
			$validator = Validator::make(array('email' => $email), array('email'=>'required|email'));
			$name = '';

			if(!$validator->fails()) 
				$this->mail($email, $name, $title, $subject);
		}
	}

	private function dbMailingSender()
	{
		$customers = Customer::where('is_active', '=', 1)->get();
		foreach ($customers as $customer)
		{
			$subject = 'Hemos añadido una nueva oferta para ti, no te la pierdas!.';
			$email = $customer->email;
			$name = $customer->customer_name;
			$title = $this->voucher->title;

			$this->mail($email, $name, $title, $subject);
		}
	}


	public function sendRemainders(Voucher $voucher)
	{
		$this->voucher = $voucher;
		$suscriptions = DB::table('customers')
		->join('suscriptions', 'customers.id', '=', 'suscriptions.customer_id')
		->join('vouchers', 'vouchers.id', '=', 'suscriptions.voucher_id')
		->where('suscriptions.is_used', '=', 0)
		->where('suscriptions.voucher_id', '=', $voucher->id)
		->select('customers.email', 'customers.customer_name', 'vouchers.title')
		->get();

		if($suscriptions)
		{
			foreach ($suscriptions as $suscription)
			{
				$subject = 'Te recordamos que aun puedes aprovechar de: "'.$suscription->title.'"';
				$email = $suscription->email;
				$name = $suscription->customer_name;
				$title = $suscription->title;

				$this->mail($email, $name, $title, $subject);
			}			

			return Redirect::back()->with('success', 'Reminders sended successfully!');
		}else{
			return Redirect::back()->with('error', 'There is any customer in this campaign.');
		}

	}

	private function mail($email, $name, $title, $subject)
	{
		Mail::send('emails.auth.advertisment', array('brief_description'=>$this->voucher->brief_description,'title'=> $this->voucher->title, 'id' => $this->voucher->id, 'name'=> $name, 'image' => $this->voucher->img, 
			'description' => $this->voucher->description, 'starts'=>$this->voucher->starts_at, 'finishes'=>$this->voucher->finishes_at), function ($message) use ($email, $name, $subject){
			$message->to($email, $name)->subject($subject);
		});
	}

	private function uploadImage($file)
	{
		$img = new ImageUpload($file,700, 526);
		$img->setDestinationFolder('voucher_img/');
		$img->saveImageReducedSize(2);

		return  $img->finalImgName;
	}


	public function editVoucherView(Voucher $voucher)
	{
		return View::make('admin.new_voucher')->with('voucher', $voucher)->with('method', 'put');
	}

	public function firstPreview(Voucher $voucher)
	{
		return View::make('admin.firstPreview')->with('voucher', $voucher);
	}

	public function newVoucherView()
	{
		$voucher = new Voucher;
		return View::make('admin.new_voucher')->with('voucher', $voucher)->with('method', 'post');
	}


	public function statistics()
	{
		//$orderBy = (!Session::get('orderBy')) ? 'desc' : Session::get('orderBy');

		$vouchers = DB::table('vouchers')
						->leftJoin('suscriptions', 'vouchers.id', '=', 'suscriptions.voucher_id')
						->select(DB::raw('count(suscriptions.customer_id) as suscribed, suscriptions.customer_id'),
								DB::raw('sum(suscriptions.is_used) as total_used, suscriptions.is_used'),
								DB::raw('sum(suscriptions.reuses) as reuses, suscriptions.customer_id'),
								'vouchers.voucher_code', 'vouchers.created_at', 'vouchers.starts_at', 'vouchers.finishes_at',
								'vouchers.sended_through_db', 'vouchers.sended_through_mailing_box', 'vouchers.id', 'vouchers.is_active',
								'vouchers.title', 'vouchers.brief_description', 'vouchers.note')
						->orderBy('vouchers.id', Session::get('orderBy'))
						->groupBy('vouchers.id')->paginate($this->getResultsPerPage());

		return $vouchers;
	}

	public function monthsActivity()
	{
		$data = DB::table('suscriptions')
		  ->select(DB::raw('MONTH(created_at) as m, count(customer_id) as total, SUM(is_used) as total_used, SUM(reuses) as total_reuses'))
		  ->whereRaw('created_at > DATE_SUB(now(), INTERVAL 1 MONTH)')
		  ->get();
		  return $data;
	}

	public function showVouchersPage()
	{
		$voucher = new Voucher;
		$vouchers = $this->statistics();
		$monthsActivity = $this->monthsActivity();
		
		return View::make('admin.vouchers')->with('vouchers', $vouchers)->with('voucher', $voucher)->with('activity', $monthsActivity);
	}

	public function delteConfirmation(Voucher $voucher){
		return View::make('admin.new_voucher')->with('voucher', $voucher)->with('method', 'delete');
	}

	public function delete(Voucher $voucher)
	{
		$voucher->delete();
		return Redirect::to('admin/vouchers')->with('success', 'Voucher successfully deleted!');
	}

	public function users()
	{
		$users = User::paginate($this->getResultsPerPage());
		return View::make('admin/users')->with('users', $users);
	}


	public function new_user()
	{
		$rules = array('user_name' => 'required', 'email'=>'email|required|unique:users');
		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails())
		{
			$user = User::create(Input::all());
			$friendlyPassword = strtolower(str_random(5));
			$password = Hash::make($friendlyPassword);
			$user->password = $password;
			$user->friendly_password = $friendlyPassword;
			$user->save();

			return Redirect::to('admin/users')->with('success', 'User created successfully!');
		}else{
			return Redirect::back()->withErrors($validator);
		}
	}

	public function edit_user_view(User $user)
	{
		return View::make('admin.user_form')->with('user', $user)->with('method', 'put');
	}

	public function edit_user(User $user)
	{
		$rules = array('user_name' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails())
		{
			$user->update(Input::all());
			$user->save();

			return Redirect::to('admin/users')->with('success', 'User updated successfully!');
		}else{
			return Redirect::back()->withErrors($validator);
		}
	}

	public function deleteUser(User $user)
	{
		$user->delete();
		return Redirect::to('admin/users')->with('success', 'User deleted successfully!');
	}

	//gestion tiendas
	public function shopsView()
	{
		$shops = Shop::paginate($this->getResultsPerPage());
		return View::make('admin/shops')->with('shops', $shops);
	}


	public function new_shop()
	{
		$rules = array('shop_name' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails())
		{
			$user = Shop::create(Input::only('shop_name'));
			$user->save();

			return Redirect::to('admin/shops')->with('success', 'Shop created successfully!');
		}else{
			return Redirect::back()->withErrors($validator);
		}
	}


	public function edit_shop_view(Shop $shop)
	{
		return View::make('admin.shop_form')->with('shop', $shop)->with('method', 'put');
	}


	public function edit_shop(Shop $shop)
	{
		$rules = array('shop_name' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails())
		{
			$shop->update(Input::only('shop_name'));
			$shop->save();

			return Redirect::to('admin/shops')->with('success', 'Shop updated successfully!');
		}else{
			return Redirect::back()->withErrors($validator);
		}
	}

	public function deleteShop(Shop $shop)
	{
		$shop->delete();
		return Redirect::to('admin/shops')->with('success', 'Shop deleted successfully!');
	}

	
}

?>