<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Guzzle\Http\Exception\ClientErrorResponseException;
use App\Todo;

class FetchData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch json stuff';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $client = new \GuzzleHttp\Client();
       try {
            $request = $client->get('https://jsonplaceholder.typicode.com/todos');
            $response = $request->getBody()->getContents();  
       } catch (ClientErrorResponseException $exception) {
           $response = $exception->getResponse()->getBody(true);
       }
       
       $data = json_decode($response, true);

       foreach ($data as $value) {
            $todo = new Todo();

            $todo->user_id = $value['userId'];
            $todo->title = $value['title'];
            $todo->completed = $value['completed'];

            $todo->save();
          
       }

      echo 'Data import Success!';
    }
}
