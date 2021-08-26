<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * send message.
     */
    public function sendMessage()
    {
        $this->validate(request(), [
            'name'    => 'required',
            'email'   => 'required',
            'message' => 'required',
        ]);

        $message = 'Phone: '.request()->phone.'<br/>   Reason: '.request()->reason.'<br/>';
        $message .= request()->message;

        try {
            Mail::send([], [], function ($email) use($message) {
                $email->to(env('MAIL_TO'))
                    ->from(request()->email, request()->name)
                    ->subject("Email From Doa Contact us page")
                    ->setBody($message, 'text/html');
            });

            return redirect()->back()->with('success', 'Message sent successfully.');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors('errors', $exception->getMessage());
        }
    }//..... end of saveContactRequest() .....//
}
