<?php  
class Searcher
{
	public $query;
	public $type;

	public function __construct($query)
	{
		$this->query = $query;
		$this->init();
	}

	public function getOldValues()
	{
		return unserialize(Session::get('search_query'));
	}

	private function setSessionQuery()
	{
		$inputs = Input::except('search');
		Session::put('search_query', serialize($inputs));
	}

	private function getInputs()
	{
		if(Session::has('search_query')){
			$inputs = $this->getOldValues();
		}else{
			$inputs = Input::except('search');
		}

		return $inputs;
	}


	public function init()
	{
		if(isset($_POST['search']))
			$this->setSessionQuery();

		$this->setQuery($this->getInputs());

	}


	private function setQuery($inputs)
	{
		foreach($inputs as $key => $value)
		{
			$value = trim($value);
			$type = $key;

			if(strlen($value) > 0)
			{
				switch($type){
					case 'email':
						$this->query->where('customers.email', '=', $value);
						break;
					case 'code':
						$this->query->where('vouchers.voucher_code', '=', $value);
						break;
					case 'customer_name':
						$this->query->where('customers.customer_name', 'LIKE', "%$value%");
						break;
					case 'title':
						$this->query->where('vouchers.title', 'LIKE', "%$value%");
						break;
					case 'reuses':
						$this->query->where('suscriptions.reuses', '=', $value);
						break;
					case 'is_active':
						if($value == 1)
						{
							$this->query->where('vouchers.is_active', '=', $value);
							$this->query->where('finishes_at', '>', date('Y/m/d', time()));
						}
						break;
					case 'is_used':
						if($value == 1)
						{
							$this->query->where('suscriptions.is_used', '=', $value);
						}
						break;
				}
			}
		}
	}

	public function getQuery()
	{
		return $this->query;
	}


}
?>