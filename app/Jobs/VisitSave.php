<?php

namespace App\Jobs;

use App\Models\Visit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VisitSave implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $os, $ip, $browser, $lang, $location;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($os, $ip, $browser, $lang, $location)
    {
        $this->os = $os;
        $this->ip = $ip;
        $this->browser = $browser;
        $this->lang = $lang;
        $this->location = $location;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Visit::create([
            'os' => $this->os,
            'ip' => $this->ip,
            'browser' => $this->browser,
            'lang' => $this->lang,
            'location' => $this->location,
        ]);
    }
}
