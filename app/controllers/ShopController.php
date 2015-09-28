<?php  
class ShopController extends ControllerCore
{
	public $query;


	public function setBasicQuery()
	{
		$this->query = DB::table('suscriptions')
			 ->join('vouchers', 'suscriptions.voucher_id', '=', 'vouchers.id')
			 ->join('customers', 'suscriptions.customer_id', '=', 'customers.id')
			 ->select('customers.email', 'customers.customer_name','customers.id as customer_id', 'vouchers.voucher_code', 
			 	'vouchers.id as id_voucher','vouchers.title', 'vouchers.is_active', 'vouchers.finishes_at', 'vouchers.starts_at', 
			 	'vouchers.note', 'suscriptions.is_used', 'suscriptions.reuses', 'suscriptions.id');
	}

	public function shop(Shop $shop)
	{
		$this->setBasicQuery();
		Session::put('shop_name', $shop->shop_name);

		$searcher = new Searcher($this->query);
		$oldValues = $searcher->getOldValues();

		$suscriptions = $searcher->getQuery()->orderBy('vouchers.finishes_at', Session::get('orderBy'))->paginate($this->resultsPerPage);

		return View::make('backoffice.shop')->with('suscriptions', $suscriptions)->with('shop', $shop)->with('oldValues', $oldValues);
	}

	public function shops()
	{
		$shops = Shop::all();
		return View::make('backoffice.shops')->with('shops', $shops);
	}
}

?>