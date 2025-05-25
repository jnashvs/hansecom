<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Stock;

class StockQuoteMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Stock $stock;

    /**
     * Create a new message instance.
     *
     * @param Stock $stock
     */
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Stock Stock for ' . $this->stock->getSymbol())
                    ->view('emails.stockquote')
                    ->with(['stock' => $this->stock]);
    }
}
