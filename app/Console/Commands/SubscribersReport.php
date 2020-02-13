<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Subscription;
use DateTime;

class SubscribersReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribers:report {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deberá recibir un parámetro del tipo fecha "YYYY-MM-DD" para generar un informe sumarizado sobre otras tablas que contenga: cantidad de nuevas suscripciones en el día, cantidad de suscripciones canceladas en el día , cantidad de suscripciones activas totales al final del día.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function validateDate ($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
 
    private function getResults($date) 
    {
        $deleted = Subscription::onlyTrashed()->whereDate('deleted_at', '=', $date)->count();
        $created = Subscription::whereDate('created_at', '=', $date)->count();
        $createdUntil = Subscription::whereDate('created_at', '<=', $date)->count();
        return ['deleted' => $deleted, 'created' => $created, 'createdUntil' => $createdUntil];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Subscribers Report");
        $date = $this->argument('date');
        if (!$this->validateDate($date)) {
            $this->error("Invalid Date: ".$date);
            $this->output->writeln("Must be: YYYY-MM-DD");
            return 0;
        } 

        $result = $this->getResults($date);
        $this->output->writeln("Subscriptions on $date: " . $result['created']);
        $this->output->writeln("Subscriptions canceled on $date: " . $result['deleted']);
        $this->output->writeln("Subscriptions until $date: " . $result['createdUntil']);

        return 0;
    }
}
