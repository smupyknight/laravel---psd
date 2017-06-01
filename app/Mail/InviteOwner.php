<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\SupportRole;

class InviteOwner extends Mailable
{
	use Queueable, SerializesModels;

	private $support_role;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(SupportRole $support_role)
	{
		$this->support_role = $support_role;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$support_role = $this->support_role;

		return $this->view('emails.invite-owner')
			->with(['email' => $support_role->email]);
	}

}
