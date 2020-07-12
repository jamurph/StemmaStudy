<?php

namespace App\Http\Controllers;

use App\ContactForm;
use Illuminate\Http\Request;

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
        $set = new ContactForm([
            'name' => request('name'),
            'email' => request('email'),
            'message' => request('message'),
        ]);
        $set->save();

        $request->session()->put('contact_form_submitted', true);
        
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
