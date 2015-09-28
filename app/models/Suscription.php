<?php  
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Suscription extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	protected $fillable = array('customer_id', 'voucher_id', 'is_used', 'reuses');
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'suscriptions';


	public function voucher()
	{
		return $this->belongsTo('Voucher');
	}

	public function customer()
	{
		return $this->belongsTo('Customer');
	}

}


?>