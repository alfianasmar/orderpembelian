<?php
session_start();
require_once 'config.php';
require_once BASE_PATH.'vendor/autoload.php';

$app            = System\App::instance();
$app->request   = System\Request::instance();
$app->route     = System\Route::instance($app->request);
$route          = $app->route;


use Model\Model as Model;
use Controller\Controller as Controller;
use Controller\Admin as Admin;


$route->get(['/','/home'], function() {
    Controller::home();
});
$route->get('/properti', function() {
    Controller::daftarProperti();
});
$route->get('/properti/detail/?', function($id) {
    Controller::detailProperti($id);
});
$route->get('/furnitur', function() {
    Controller::daftarFurnitur();
});
$route->get('/furnitur/detail/?', function($id) {
    Controller::detailFurnitur($id);
});
$route->get('/furnitur/bayar',function(){
	Controller::bayar($judul);
});
//ROUTE ADMIN
$route->group('/admin',function(){
	$this->get('/',function(){
    Admin::home();
	});
  //ROUTE MITRA
  $this->group('/mitra',function(){
    $this->get('/',function(){
      Admin::mitra();
    });
    $this->get('/add',function(){
      Admin::addMitra();
    });
    $this->post('/add',function(){
      Admin::addMitra('submit');
    });
    $this->get('/edit/?',function($id){
      Admin::editMitra($id);
    });
    $this->post('/edit/?',function($id){
      Admin::editMitra($id,'submit');
    });
    $this->get('/delete/?',function($id){
      Admin::deleteMitra($id);
    });
  });
  //ROUTE Properti
  $this->group('/properti',function(){
    $this->get('/',function(){
      Admin::properti();
    });
    $this->get('/add',function(){
      Admin::addProperti();
    });
    $this->post('/add',function(){
      Admin::addProperti('submit');
    });
    $this->get('/edit/?',function($id){
      Admin::editProperti($id);
    });
    $this->post('/edit/?',function($id){
      Admin::editProperti($id,'submit');
    });
    $this->get('/delete/?',function($id){
      Admin::deleteProperti($id);
    });
  });
  //ROUTE FURNITUR
  $this->group('/furnitur',function(){
    $this->get('/',function(){
      Admin::furnitur();
    });
    $this->get('/add',function(){
      Admin::addFurnitur();
    });
    $this->post('/add',function(){
      Admin::addFurnitur('submit');
    });
    $this->get('/edit/?',function($id){
      Admin::editFurnitur($id);
    });
    $this->post('/edit/?',function($id){
      Admin::editFurnitur($id,'submit');
    });
    $this->get('/delete/?',function($id){
      Admin::deleteFurnitur($id);
    });
  });

});
//ROUTE NOT FOUND
$route->get(['/*'],function(){
	Controller::notReady();
})->as('notReady');


$route->end();

?>
