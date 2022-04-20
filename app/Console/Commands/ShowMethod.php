<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Http\Controllers\CollectionsController;

class ShowMethod extends Command
{

    protected $signature = 'show:method {action}';
    protected $description = 'Laravel Collection';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle( CollectionsController $controller)
    {
        // call the controller
        //$controller = new App\Http\Controller\CollectionsController();
        //$controller = app()->make("App\Http\Controllers\CollectionsController");

        //$action = $this->ask('action');
        //print_r($controller->index());

        $action = $this->argument('action');
        $controller->$action();
       
    }
}
