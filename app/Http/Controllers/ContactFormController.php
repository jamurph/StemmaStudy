<?php

namespace App\Http\Controllers;

use App\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class ContactFormController extends Controller
{


    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:2', 'max:50'],
            'email' => ['required','email', 'max:320'],
            'message' => ['required', 'min:10', 'max:1000'],
        ]);

        $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret'),
            'response' => $request->get('recaptcha')
        ]);

        if($recaptchaResponse['success'] && $recaptchaResponse['score'] > 0.5){
            $form = new ContactForm([
                'name' => request('name'),
                'email' => request('email'),
                'message' => request('message'),
            ]);
            $form->save();
    
            $request->session()->put('contact_form_submitted', true);
    
            Mail::raw('A contact form was submitted by ' . request('name') . ' at ' . request('email') . ". \r\nHere is what they said: \r\n\r\n" . request('message'), function ($message) {
                $message->to('murph@stemmastudy.com');
                $message->subject('New Contact Form');
            });
        }

        return redirect()->route('contact_thanks');
    }

    public function thanks(Request $request){
        //only show thanks message if they come here after submitting a form. Otherwise, redirect to the form.
        if($request->session()->pull('contact_form_submitted', false) == true){
            return view('contact.thanks');
        }else {
            return redirect()->route('contact_create');
        }
    }
}
