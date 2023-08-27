<?php
namespace App\Controllers;

//Use this class to train your chatbot 
use Config\Sarufi as confSarufi;
use Alphaolomi\Sarufi\Sarufi as Sarufi;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class Training extends Controller{
    use ResponseTrait;

    // define some constant variables here 
    protected $Sarufi;
    public    $request;
    public    $Client;

    // trainig array 
    public const trainingArray = array(
            'desc' => 'Sisi tunauza masaishuka na nguo za kiutamaduni, tunapatikana arusha',
            'intents'=>[
              'greets'=> [ 'hujambo', 'habari','za asubui', 'za mchana', 'mambo', 'niaje ','boss'
              ],
              'goodbye'=> [ 'Asante', 'Karibu tena', 'Asante sana', 'Nashukuru boss'
              ],
              'order_shuka'=> [ 'Nahitaji masaishuka', 'Naitaji mashuka', 'Masai shuka zipo', 'Natoa order ya masaishuka'
              ],
              'type_shuka'=> [ 'Zipo nyekundu', 'zipo mchanganyiko wa nyekundu na nyeusi', 'Kijani na bluu','Kijani','Nyekundu','bluu','ugoro','nyeusi','boks kubwa'],
            ],
            'flow'=>[
                "greets"=> [
                    "message"=> [
                    "Mambo vipi, nikusaidieje mkuu?"
                    ],
                    "next_state"=> "order_shuka"
                ],
                "order_shuka"=> [
                    "message"=> [
                    "Sawa boss, Nikuwekee aina ipi boss? naomba nitajie rangi"
                    ],
                    "next_state"=> "type_shuka"
                ],
                "type_shuka"=> [
                    "message"=> [
                    "Sawa boss, izo zipo, Niweke mashuka mangapi?"
                    ],
                    "next_state"=> "number_of_shuka"
                ],
                "number_of_shuka" =>[
                    "message"=> [
                    "Sawa boss, naomba anwani yako au nipeleke gari gani?"
                    ],
                    "next_state" => "address"
                ],
                "address" => [
                    "message" => [
                    "Naomba na namba yako ya simu?"
                    ],
                    "next_state" => "phone_number"
                ],
                "phone_number" => [
                    "message" => [
                    "YNashukuru boss order yako inashuhulikiwa",
                    "Asante sana boss mzigo wako uko tayari asante sana boss."
                    ],
                    "next_state" => "end"
                ],
                "goodbye" => [
                    "message" => [
                    "Bye",
                    "Tuendelee kuwasiliana boss wangu"
                    ],
                    "next_state" => "end"
                ]
            ]
    );

    // initialise class during call 
    public function __construct()
    {
        $this->Sarufi = new Sarufi(confSarufi::$apiKey);
        $this->request = \Config\Services::request();
    }

    public function trainWithArray(array $array) {
        // check for empty array and send error/ exception 
        if(empty($array)){
            return $this->respond(['error' => 'Training araay is empty']);
        }
        else{
            $updates = $this->Sarufi->updateBot(confSarufi::$botId,'YaKwetu','Culture',$array['desc'],$array['intents'],$array['flow'],true);

            // after training with our array we terminate this method by notifying our front end 
            return $this->respond($updates);
        }
    }

    public function index() {
        // run the training method
        return $this->respond($this->trainWithArray($this::trainingArray));
    }

}