 
<!-- Welcome Section with Logo -->
<div class="welcome-section">
  <div class="logo-container">
    <img src="<?=BRAND ?>banquet-logo.png" alt="Banquet Logo" class="banquet-logo">
  </div>
  <h1>Welcome to Banquet MVC Tool PHP</h1>
  <p class="lead">
  
Banquet streamlines development through automatic generation of the application layer components<br> (Entity, DAO, Model, Service, REST API, and Routes  

</p>
</div>

<!-- Features Section -->
<div class="features-section">
  <div class="row">
    <div class="col-md-4">
      <div class="feature-box">
        <h3>🏗️ Clean Architecture</h3>
        <p>Well-organized MVC structure with clear separation of concerns. Actions, views, and models are neatly separated for maintainability.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="feature-box">
        <h3>🔌 REST API Ready</h3>
        <p>Built-in support for REST APIs with authorization. Create and manage APIs with ease using the framework's REST components.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="feature-box">
        <h3>🔐 Security First</h3>
        <p>JWT authentication, encryption support, and CORS configuration out of the box for secure applications.</p>
      </div>
    </div>
  </div>
</div>

<!-- API Examples Section -->
<div class="api-examples-section">
  <h2>Quick API Examples</h2>
  
  <div class="api-example">
    <h4>Creating a REST Endpoint</h4>
    <div class="code-block">
      <pre><code>// In app/src/Actions/Api/YourApi.php
namespace Banquet\Actions\Api;
use Banquet\Core\SenderAction;

class YourApi extends SenderAction {
 
  public function send() {

    $response = ['data' => 'your data'];
    
    $this->respondOk($dataResp);
  
    }
 

}</code></pre>
    </div>
  </div>

  <div class="api-example">
    <h4>Using Services & DAOs</h4>
    <div class="code-block">
      <pre><code>// Services layer for business logic
use Banquet\Core\SenderAction;
use Banquet\Service\CorsiService;

class Corsi extends SenderAction{
     // Classe Corsi di esempio per la gestione della View Corsi tramite template
    private $service;
    public function __construct(CorsiService $service) {
        $this->service=$service;
    }

    public function send() {
         $this->setTemplateName("pages/corsi");

         $this->varAdd("corsi", $this->service->getAllCorsi());

        return $this->getTemplate("default");
    }
}

 
 </code></pre>
    </div>
  </div>

  <div class="api-example">
    <h4>Router Configuration</h4>
    <div class="code-block">
      <pre><code>// In app/src/routes/web.php
$router = new Router();
$router->add('/api/courses', 'CorsiRest');
$router->add('/courses', 'Corsi');
$router->dispatch();</code></pre>
    </div>
  </div>
</div>

<!-- Quick Links -->
<div class="quick-links-section">
  <h2>Get Started</h2>
  <div class="row">
    <div class="col-md-6">
      <a href="/doc" class="btn btn-primary btn-lg">📖 Read Documentation</a>
    </div>
    <div class="col-md-6">
      <a href="/start" class="btn btn-info btn-lg">🎓 View Examples</a>
    </div>
  </div>
</div>


 