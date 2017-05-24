<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use DateTime;

class GenerateDN extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sources {className} {--all}
                                             {--c}{--controller} {--notc}{--notcontroller} 
                                             {--mi}{--migration} {--notmi}{--notmigration}
                                             {--mo}{--model}     {--notmo}{--notmodel} 
                                             {--d}{--dao}        {--notd}{--notdao} 
                                             {--n}{--negocio}    {--notn}{--notnegocio} 
                                             {--i}{--interface}  {--noti}{--notinterface}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comand generate Dao, Negocio, Model, Interface and Controller of the name basic class';

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
        // $this->info("Class: " . $this->argument('className') . " |d: " . $this->option('d') . " |n: " . $this->option('n'));


        $pathAPP = app_path() . "/Models/Model" . $this->argument('className') . "/";

        $pathAPPController = app_path() . "/Http/Controllers/";

        $className = ucfirst($this->argument('className'));
        $dateTime = new DateTime();
        $crateModel = "false";
        $crateController = "false";
        $crateMigration =  "false";
        $crateDao = "false";
        $crateNegocio = "false";
        $crateInterface = "false";

        if($this->option('all') > 0){

            $crateModel = "true";
            $crateController = "true";
            $crateMigration = "true";
            $crateDao = "true";
            $crateNegocio = "true";
            $crateInterface = "true";

            if($this->option('notmo') > 0 || $this->option('notmodel') > 0) {
                $crateModel = "false";
            }

            if($this->option('notc') > 0 || $this->option('notcontroller') > 0) {
                $crateController = "false";
            }

            if($this->option('notmi') > 0 || $this->option('notmigration') > 0) {
                $crateMigration = "false";
            }

            if($this->option('notd') > 0 || $this->option('notdao') > 0) {
                $crateDao = "false";
            }

            if($this->option('notn') > 0 || $this->option('notnegocio') > 0) {
                $crateNegocio = "false";
            }

            if($this->option('noti') > 0 || $this->option('notinterface') > 0) {
                $crateInterface = "false";
            }

        }else{

            if($this->option('mo') > 0 || $this->option('model') > 0) {
                $crateModel = "true";
            }

            if($this->option('c') > 0 || $this->option('controller') > 0) {
                $crateController = "true";
            }

            if($this->option('mi') > 0 || $this->option('migration') > 0) {
                $crateMigration = "true";
            }

            if($this->option('d') > 0 || $this->option('dao') > 0) {
                $crateDao = "true";
            }

            if($this->option('n') > 0 || $this->option('negocio') > 0) {
                $crateNegocio = "true";
            }

            if($this->option('i') > 0 || $this->option('interface') > 0) {
                $crateInterface = "true";
            }
        }

        if ($crateModel == 'true') {
            $this->info("Creaating Model " . $className);
            $this->info(exec('php artisan make:model Models/Model' . $className . "/" . $className));
        }
        if ($crateMigration == 'true') {
            $this->info("Creaating Migration " . $className);
            $this->info(exec('php artisan make:migration create_' . strtolower($className) . "s_table"));
        }
        if ($crateController == 'true') {
            $this->info("Creaating Controller " . $className);
            //  $this->info(exec('php artisan make:controller ' . $className . "Controller"));


            if (!File::exists($pathAPPController . $className . "Controller.php")) {


                $contentController =
                    "<?php
/**
 * Created commandline  #generate:sources#.
 * User: john Rômulo
 * Date: " . date_format($dateTime, 'd') . "/" . date_format($dateTime, 'm') . "/" . date_format($dateTime, 'Y') . "
 * Time: " . date_format($dateTime, 'H') . ":" . date_format($dateTime, 'i') . "
*/  

namespace App" . str_replace("'", "", addslashes("'")) . "Http" . str_replace("'", "", addslashes("'")) . "Controllers;

use Illuminate" . str_replace("'", "", addslashes("'")) . "Support" . str_replace("'", "", addslashes("'")) . "Facades" . str_replace("'", "", addslashes("'")) . "Input;
use App" . str_replace("'", "", addslashes("'")) . "Models" . str_replace("'", "", addslashes("'")) . "Model" . $className . str_replace("'", "", addslashes("'")) . $className . ";
use App" . str_replace("'", "", addslashes("'")) . "Models" . str_replace("'", "", addslashes("'")) . "Model" . $className . str_replace("'", "", addslashes("'")) . $className . "Negocio;
use App" . str_replace("'", "", addslashes("'")) . "Util" . str_replace("'", "", addslashes("'")) . "ResponseMessage;
use App" . str_replace("'", "", addslashes("'")) . "Util" . str_replace("'", "", addslashes("'")) . "GlobalEnum;



class " . $className . "Controller extends Controller 
{
    private $" . strtolower($className) . "Negocio = null;
    private $" . strtolower($className) . " = null;
    
    public function __construct()
    {
        $" . "this" . "->" . strtolower($className) . "Negocio = new " . $className . "Negocio();
        $" . "this" . "->" . strtolower($className) . " = new " . $className . "();
        $" . "this" . "->responseMessage  =  new ResponseMessage();
        $" . "this" . "->globalEnum  =  new GlobalEnum();
    }
  
    public function save" . $className . "()
    {
        $" . "input = Input::all();
        $" . "this" . "->" . strtolower($className) . "->fill($" . "input);
        
        $" . "retorno = $" . "this" . "->" . strtolower($className) . "Negocio->save" . $className . "($" . "this" . "->" . strtolower($className) . ");
        
         if ($" . "retorno['" . strtolower($className) . "'] != null) {         
            return response()->json(array('response' => $" . "this->responseMessage->operationOK($" . "this->globalEnum->CLASS_" . strtoupper($className) . ", $" . "this->globalEnum->INSERTED)), $" . "this->globalEnum->HTTP_OK);          
         }else{       
            return response()->json(array('response' => $" . "this->responseMessage->operationError($" . "this->globalEnum->CLASS_" . strtoupper($className) . ", $" . "this->globalEnum->INSERT,$" . "retorno['mensagem'])), $" . "this->globalEnum->HTTP_BAD_REQUEST);
         }
    }
    
    public function update" . $className . "($" . "id)
    {
        $" . "input = Input::all();
        //$" . "this" . "->" . strtolower($className) . "= " . $className . "::find($" . "id);
        $" . "this" . "->" . strtolower($className) . "->fill($" . "input);
        $" . "this" . "->" . strtolower($className) . "->id = $" . "id;
        
        $" . "retorno = $" . "this" . "->" . strtolower($className) . "Negocio->update" . $className . "($" . "this" . "->" . strtolower($className) . ");
        
         if ($" . "retorno['" . strtolower($className) . "'] != null) {         
            return response()->json(array('response' => $" . "this->responseMessage->operationOK($" . "this->globalEnum->CLASS_" . strtoupper($className) . ", $" . "this->globalEnum->UPDATED)), $" . "this->globalEnum->HTTP_OK);          
         }else{       
            return response()->json(array('response' => $" . "this->responseMessage->operationError($" . "this->globalEnum->CLASS_" . strtoupper($className) . ", $" . "this->globalEnum->UPDATE,$" . "retorno['mensagem'])), $" . "this->globalEnum->HTTP_BAD_REQUEST);
         }
        
       
    }
    
    public function listAll" . $className . "()
    {
        return response()->json(array('response' =>  array('list'.$" . "this->globalEnum->CLASS_" . strtoupper($className) . " => $" . "this->" . strtolower($className) . "Negocio->listAll" . $className . "()), $"."this->globalEnum->HTTP_OK));
    }
    
    public function list" . $className . "($" . "id)
    {
        $" . "input = Input::all();
        //$" . "this" . "->" . strtolower($className) . "= " . $className . "::find($" . "id);
        $" . "this" . "->" . strtolower($className) . "->fill($" . "input);
        $" . "this" . "->" . strtolower($className) . "->id = $" . "id;
        return response()->json(array('response' =>  array('list'.$" . "this->globalEnum->CLASS_" . strtoupper($className) . " => $" . "this->" . strtolower($className) . "Negocio->list" . $className . "($"."this->".strtolower($className)."))), $"."this->globalEnum->HTTP_OK);
       
    }
    
    public function delete" . $className . "($" . "id)
    {
        $" . "input = Input::all();
        //$" . "this" . "->" . strtolower($className) . "= " . $className . "::find($" . "id);
        $" . "this" . "->" . strtolower($className) . "->fill($" . "input);
        $" . "this" . "->" . strtolower($className) . "->id = $" . "id;
        
         $" . "retorno = $" . "this" . "->" . strtolower($className) . "Negocio->delete" . $className . "($" . "this" . "->" . strtolower($className) . ");
        
         if ($" . "retorno['" . strtolower($className) . "'] != null) {         
            return response()->json(array('response' => $" . "this->responseMessage->operationOK($" . "this->globalEnum->CLASS_" . strtoupper($className) . ", $" . "this->globalEnum->DELETED)), $" . "this->globalEnum->HTTP_OK);          
         }else{       
            return response()->json(array('response' => $" . "this->responseMessage->operationError($" . "this->globalEnum->CLASS_" . strtoupper($className) . ", $" . "this->globalEnum->DELETE,$" . "retorno['mensagem'])), $" . "this->globalEnum->HTTP_BAD_REQUEST);
         }
      
    }

}";


                File::put($pathAPPController . $className . "Controller.php", $contentController);
                $this->info("Controller created successfully");

            } else {
                $this->info("Controller already exists");
            }


        }

        if ($crateDao == 'true') {
            $this->info("Creaating Dao " . $className);
            if (!File::exists($pathAPP)) {
                File::makeDirectory($pathAPP, 0777, true, true);
            }

            if (!File::exists($pathAPP . $className . "Dao.php")) {

                $contentDao =
                    "<?php
/**
 * Created commandline  ##generate:sources#.
 * User: john Rômulo
 * Date: " . date_format($dateTime, 'd') . "/" . date_format($dateTime, 'm') . "/" . date_format($dateTime, 'Y') . "
 * Time: " . date_format($dateTime, 'H') . ":" . date_format($dateTime, 'i') . "
*/  

namespace App" . str_replace("'", "", addslashes("'")) . "Models" . str_replace("'", "", addslashes("'")) . "Model" . $className . ";

use App" . str_replace("'", "", addslashes("'")) . "Models" . str_replace("'", "", addslashes("'")) . "Model" . $className . str_replace("'", "", addslashes("'")) . $className . ";

class " . $className . "Dao implements" . $className . "Interface 
{

    private $" . strtolower($className) . " = null;
 
    public function __construct()
    {
       $" . "this" . "->" . strtolower($className) . " = new " . $className . ";
    }
  

    public function save" . $className . "(" . $className . " $" . strtolower($className) . ")
    {
        $" . "this" . "->" . strtolower($className) . " = $" . strtolower($className) . ";
        
        $" . "isSaved = $" . "this->" . strtolower($className) . "->save();
       
        $" . "retorno = array(
            '" . strtolower($className) . " ' => '',
            'mensagem' => ''
        );
       
        if($" . "isSaved){
        
            $" . "retorno['" . strtolower($className) . "'] = $" . "this->" . strtolower($className) . ";
            $" . "retorno['mensagem'] = '';
            return  $" . "retorno;
        
        }else{
            $" . "retorno['" . strtolower($className) . "'] = null;
            $" . "retorno['mensagem'] = 'Erro ao inserir " . strtolower($className) . "';
            return  $" . "retorno;
        }
    }
    
    
    
    public function update" . $className . "(" . $className . " $" . strtolower($className) . ")
    {
        $" . "this" . "->" . strtolower($className) . " = " . $className . "::find($" . strtolower($className) . "->id);
        $" . "this" . "->" . strtolower($className) . "->fill($" . strtolower($className) . "->toArray());
        
        $" . "isSaved = $" . "this->" . strtolower($className) . "->save();
        
         $" . "retorno = array(
            '" . strtolower($className) . " ' => '',
            'mensagem' => ''
        );
       
        if($" . "isSaved){
        
            $" . "retorno['" . strtolower($className) . "'] = $" . "this->" . strtolower($className) . ";
            $" . "retorno['mensagem'] = '';
            return  $" . "retorno;
        
        }else{
            $" . "retorno['" . strtolower($className) . "'] = null;
            $" . "retorno['mensagem'] = 'Erro ao alterar " . strtolower($className) . "';
            return  $" . "retorno;
        }
          
    }
    
    public function list" . $className . "(" . $className . " $" . strtolower($className) . ")
    {
        return   $" . "this" . "->" . strtolower($className) . " = " . $className . "::find($" . strtolower($className) . "->id);  
    }
    
    public function listAll" . $className . "()
    {
        return  $" . "this" . "->" . strtolower($className) . "->all();
    }
    
    public function delete" . $className . "(" . $className . " $" . strtolower($className) . ")
    {
        $" . "this" . "->" . strtolower($className) . " = " . $className . "::find($" . strtolower($className) . "->id);
        $" . "this" . "->" . strtolower($className) . "->fill($" . strtolower($className) . "->toArray());
    
        $" . "retorno = array(
            '" . strtolower($className) . " ' => '',
            'mensagem' => ''
        );
        
         $" . "idDeleted = $" . "this" . "->" . strtolower($className) . "->delete();
         
          if($" . "idDeleted){
        
            $" . "retorno['" . strtolower($className) . "'] = $" . "this->" . strtolower($className) . ";
            $" . "retorno['mensagem'] = '';
            return  $" . "retorno;
        
          }else{
            $" . "retorno['" . strtolower($className) . "'] = null;
            $" . "retorno['mensagem'] = 'Erro ao remover " . strtolower($className) . "';
            return  $" . "retorno;
          }
         
    }

}";

                File::put($pathAPP . $className . "Dao.php", $contentDao);
                $this->info("Dao created successfully");
            } else {
                $this->info("Dao already exists");
            }


        }

        if ($crateNegocio == 'true') {
            $this->info("Creaating Negocio " . $className);
            if (!File::exists($pathAPP)) {
                File::makeDirectory($pathAPP, 0777, true, true);
            }


            if (!File::exists($pathAPP . $className . "Negocio.php")) {

                $contentNegocio =
                    "<?php
/**
 * Created commandline  ##generate:sources#.
 * User: john Rômulo
 * Date: " . date_format($dateTime, 'd') . "/" . date_format($dateTime, 'm') . "/" . date_format($dateTime, 'Y') . "
 * Time: " . date_format($dateTime, 'H') . ":" . date_format($dateTime, 'i') . "
*/  

namespace App" . str_replace("'", "", addslashes("'")) . "Models" . str_replace("'", "", addslashes("'")) . "Model" . $className . ";

use App" . str_replace("'", "", addslashes("'")) . "Models" . str_replace("'", "", addslashes("'")) . "Model" . $className . str_replace("'", "", addslashes("'")) . $className . ";
use App" . str_replace("'", "", addslashes("'")) . "Models" . str_replace("'", "", addslashes("'")) . "Model" . $className . str_replace("'", "", addslashes("'")) . $className . "Dao;

class " . $className . "Negocio implements" . $className . "Interface 
{

    private $" . strtolower($className) . "Dao = null;
    
    public function __construct()
    {
       $" . "this" . "->" . strtolower($className) . "Dao = new " . $className . "Dao;
      
     
    }
    
    public function save" . $className . "(" . $className . " $" . strtolower($className) . ")
    {    
    
    
        return $" . "this" . "->" . strtolower($className) . "Dao->save" . $className . "($" . strtolower($className) . ");
         
        /*
        $" . "this" . "->" . strtolower($className) . "  = $" . "this" . "->" . strtolower($className) . "Dao->save" . $className . "($" . strtolower($className) . ");
        if ($" . "this" . "->" . strtolower($className) . " != null) {
            return $" . "this->responseMessage->successInsert($" . "this->globalEnum->CLASS_" . strtoupper($className) . ", $" . "this" . "->" . strtolower($className) . " );
        } else {
            return $" . "this->responseMessage->errorInsert($" . "this->globalEnum->CLASS_" . strtoupper($className) . ");
        }
        */
        
    }
    
    public function update" . $className . "(" . $className . " $" . strtolower($className) . ")
    {    
       
        return $" . "this" . "->" . strtolower($className) . "Dao->update" . $className . "($" . strtolower($className) . ");
     
     /*
        $" . "this" . "->" . strtolower($className) . "  = $" . "this" . "->" . strtolower($className) . "Dao->update" . $className . "($" . strtolower($className) . ");
        if ($" . "this" . "->" . strtolower($className) . " != null) {
            return $" . "this->responseMessage->successUpdate($" . "this->globalEnum->CLASS_" . strtoupper($className) . ", $" . "this" . "->" . strtolower($className) . " );
        } else {
            return $" . "this->responseMessage->errorUpdate($" . "this->globalEnum->CLASS_" . strtoupper($className) . ");
        }
        */
    }
    
    public function list" . $className . "(" . $className . " $" . strtolower($className) . ")
    {                  
        return $" . "this->responseMessage->listObject($" . "this->globalEnum->CLASS_" . strtoupper($className) . ", $" . "this" . "->" . strtolower($className) . "Dao->list" . $className . "($" . strtolower($className) . "));
        /*
        return $" . "this" . "->" . strtolower($className) . "Dao->list" . $className . "($" . strtolower($className) . ");
        */
    }
    
    public function listAll" . $className . "()
    {      
       return $" . "this" . "->" . strtolower($className) . "Dao->listAll" . $className . "();
       /*
       return $" . "this->responseMessage->listObject($" . "this->globalEnum->CLASS_" . strtoupper($className) . ", $" . "this" . "->" . strtolower($className) . "Dao->listAll" . $className . "();
       */
    }
    
    public function delete" . $className . "(" . $className . " $" . strtolower($className) . ")
    {
    
        return $" . "this" . "->" . strtolower($className) . "Dao->deleteUser($" . strtolower($className) . ");
      
      /*
        $" . "isDeleted = $" . "this" . "->" . strtolower($className) . "Dao->deleteUser($" . strtolower($className) . ");
        if ($" . "isDeleted == true) {
            return $" . "this->responseMessage->successDelete($" . "this->globalEnum->CLASS_" . strtoupper($className) . ");
        } else {
            return $" . "this->responseMessage->errorDelete($" . "this->globalEnum->CLASS_" . strtoupper($className) . ");
        }
      */
    }

}";
                File::put($pathAPP . $className . "Negocio.php", $contentNegocio);
                $this->info("Negocio created successfully");
            } else {
                $this->info("Negocio already exists");
            }


        }

        if ($crateInterface == 'true') {
            $this->info("Creaating Interface " . $className);
            if (!File::exists($pathAPP)) {
                File::makeDirectory($pathAPP, 0777, true, true);
            }


            if (!File::exists($pathAPP . $className . "Negocio.php")) {

                $contentNegocio =
                    "<?php
/**
 * Created commandline  ##generate:sources#.
 * User: john Rômulo
 * Date: " . date_format($dateTime, 'd') . "/" . date_format($dateTime, 'm') . "/" . date_format($dateTime, 'Y') . "
 * Time: " . date_format($dateTime, 'H') . ":" . date_format($dateTime, 'i') . "
*/  

namespace App" . str_replace("'", "", addslashes("'")) . "Models" . str_replace("'", "", addslashes("'")) . "Model" . $className . ";

interface " . $className . "Interface 
{

    public function save" . $className . "(" . $className . " $" . strtolower($className) . ");
   
    
    public function update" . $className . "(" . $className . " $" . strtolower($className) . ");
  
    
    public function list" . $className . "(" . $className . " $" . strtolower($className) . ");
   
    
    public function listAll" . $className . "();
  
    
    public function delete" . $className . "(" . $className . " $" . strtolower($className) . ");
    

}";
                File::put($pathAPP . $className . "Interface.php", $contentNegocio);
                $this->info("Interface created successfully");
            } else {
                $this->info("Interface already exists");
            }


        }

    }
}
