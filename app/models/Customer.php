<?php  
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Customer extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	protected $fillable = array('email', 'phone', 'is_active');
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'customers';

}


?>