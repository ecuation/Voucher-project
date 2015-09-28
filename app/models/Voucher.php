<?php  
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Voucher extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	protected $fillable = array('title', 'brief_description', 'description', 'img', 'sended_through_db','sended_through_mailing_box', 'starts_at', 'finishes_at', 'is_active', 'voucher_code', 'note');
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'vouchers';

}


?>