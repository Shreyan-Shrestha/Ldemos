<?php

namespace App\Http\Controllers;

use App\Mail\OrderCreatedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    // public function sendEmail() : string
    // {
    //     Mail::to('shreyan.freelance@gmail.com')->send(new OrderCreatedMail($order));
    //     return "Email sent successfully!";
    // }
}
